/**
 * @author: Puji Ermanto <pujiermanto@gmail.com>
 * Desc: File ini merupakan serangkaian instruksi untuk melakukan manipulasi data dan element pada struktur html. Melakukan ajax request secara asynchronous, sehingga memungkinkan untuk menambahkan nilai visual pada user experience.
 * */

let cells = []

// Check checkbox displaying data laporan
// Ambil data dari tabel setelah checkbox dipilih
function getDataFromTable(selectType) {
  selectedData = [];

  if (selectType === 'checkAll') {
    // Jika selectType adalah 'checkAll', ambil semua data dari tabel
    $(".dataCheckbox").each(function() {
      const kdObat = $(this).val();
      const eoqId = $(this).closest("tr").find(".eoq-id").data("id");
      const rowData = {
        kd_obat: kdObat,
        id: eoqId
      };
      selectedData.push(rowData);
    });
  } else if (selectType === 'checkIndividual') {
    // Jika selectType adalah 'checkIndividual', ambil data yang dipilih
    $(".dataCheckbox:checked").each(function() {
      const kdObat = $(this).val();
      const eoqId = $(this).closest("tr").find(".eoq-id").data("id");
      const rowData = {
        kd_obat: kdObat,
        id: eoqId
      };
      selectedData.push(rowData);
    });
  }
}


$('#displaying').on('click', '#print-laporan', function(e) {
   e.preventDefault();
   if(selectedData.length > 0) {
      closeSelectedBtn.show().fadeIn(1000)
      $.ajax({
         url: '/print/laporan-eoq',
         type: 'POST',
         dataType: 'json',
         data: { selectedData: selectedData },
         startTime: new Date().getTime(),
         success: function(response) {
            if (response.success) {
               // Mengambil konten dari elemen dengan id "tableContainerHeader"
               let tableContainerHeaderContent = $('#tableContainerHeader').html();
      
               // hide table laporan
               printLaporanBtn.hide('slow').fadeOut(1000);
               closeSelectedBtn.removeClass('hidden');

               const tableData = response.data;

               let table = '<table class="dom-laporan-table">';
               table += `
               <thead>
               <tr>
               <th>Kode Obat</th>
               <th>Nama Obat</th>
               <th>Kebutuhan Pertahun</th>
               <th>Biaya Simpan</th>
               <th>Biaya Pesan</th>
               <th>Jumlah Economics</th>
               <th>Waktu Pemesanan</th>
               </tr>
               </thead>
               <tbody>
               `;

               for (let i = 0; i < tableData.length; i++) {
                  table += `
                  <tr>
                  <td>${tableData[i].kd_obat}</td>
                  <td>${tableData[i].nm_obat}</td>
                  <td>${tableData[i].k_tahun}</td>
                  <td>${formatIdr(tableData[i].b_simpan)}</td>
                  <td>${formatIdr(tableData[i].b_pesan)}</td>
                  <td>${hitungEconomics({
                     b_pesan: tableData[i].b_pesan,
                     k_tahun: tableData[i].k_tahun,
                     b_simpan: tableData[i].b_simpan
                  })} ${tableData[i].jenis_obat}</td>
                  <td>${hitungIntervalWaktu({
                     b_pesan: tableData[i].b_pesan,
                     k_tahun: tableData[i].k_tahun,
                     b_simpan: tableData[i].b_simpan
                  })} Hari</td>
                  </tr>`;
               }

               table += `
               </tbody>

               <tfoot class="table-footer">`
               Array.from({ length: 5 }).map(() => {
                   table += `
                   <tr>
                   <td colspan="4" class="float-right font-bold"></td>
                   </tr>
                   `;
                }); 

               table +=   
                  `<tr>
                     <td colspan="5" class="font-bold"></td>
                     <td colspan="4" class="font-bold">Bogor, ${dateFormat()}</td>
                  </tr>
                  <tr>
                     <td colspan="5" class="font-bold"></td>
                     <td colspan="4" class="font-bold" style="margin-top: -12rem!important;">Mengetahui</td>
                  </tr>`

               Array.from({ length: 4 }).map(() => {
                   table += `
                   <tr>
                   <td colspan="4" class="float-right font-bold"></td>
                   </tr>
                   `;
                });

               table +=  
               `<tr>
                     <td colspan="5" class="font-bold"></td>
                     <td colspan="4" class="name font-bold">
                     ${name}
                     </td>
                  </tr>
               </tfoot>

               `

               table += '</table>';

               // Mengubah konten elemen "tableContainer" dengan tabel baru
               $('#tableContainer').html(table)
               // Memasukkan kembali konten elemen anak dengan id "tableContainerHeader"
               $('#tableContainer').prepend(tableContainerHeaderContent)

               // Mengubah properti "display" menjadi "flex" pada elemen anak dengan id "tableContainerHeader"
               $('#tableContainerHeader').css('display', 'flex')

               loading.classList.remove('hidden')
               loading.classList.add('block')

               setTimeout(() => {
                  loading.classList.remove('block')
                  loading.classList.add('hidden')
                  generatePDF(response.data)
               }, 1000)
            }
         }
      })
   } else {
      Swal.fire(
         'Ooppps?',
       'Pilih data laporan EOQ terlebih dahulu ?',
       'question'
       )
      closeSelectedBtn.hide()
   }
})


function generatePDF() {  
   $(".dataCheckbox").prop("checked", false);
   $("#checkAll").prop("checked", false);
   // printLaporanBtn.show().fadeIn(1000)
   closeSelectedBtn.addClass('hidden')
   container = $('#tableContainer');

	getCanvas().then(function (canvas) {  
		let img = canvas.toDataURL("image/png"),  
		doc = new jsPDF({  
			unit: 'px',  
			format: 'a4'  
		})
		doc.addImage(img, 'JPEG', 20, 20)
      // aktifkan bagian ini (doc.save) jika ingin file pdf otomatis langsung tersimpan 
		// doc.save('laporan-eoq.pdf')
      // doc.output('dataurlnewwindow', 'laporan-eoq-preview.pdf')
      let pdfWindow = window.open("");
      pdfWindow.document.write(`<iframe width='100%' height='100%' src='${doc.output('datauristring')}'></iframe>`);
      pdfWindow.document.title = 'laporan-eoq-preview.pdf'

      const pageCount = doc.internal.getNumberOfPages();
      for (let i = 0; i < pageCount; i++) {
         doc.setPage(i);
         doc.setFontSize(8);
         doc.setTextColor(128);
         doc.text(20, doc.internal.pageSize.getHeight() - 10, `Page ${i + 1} of ${pageCount}`);
      }

		container.width(cache_width)
	})



}  

function getCanvas() {  
	container.width((a4[0] * 1.33333) - 80).css('max-width', 'none')
	return html2canvas(container, {  
		imageTimeout: 500,  
		removeContainer: true  
	})
}