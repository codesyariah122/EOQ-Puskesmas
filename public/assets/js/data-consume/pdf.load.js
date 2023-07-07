/**
 * @author: Puji Ermanto <pujiermanto@gmail.com>
 * Desc: File ini merupakan serangkaian instruksi untuk melakukan manipulasi data dan element pada struktur html. Melakukan ajax request secara asynchronous, sehingga memungkinkan untuk menambahkan nilai visual pada user experience.
 * */

// Check checkbox displaying data laporan
let cells = []

// Ambil data dari tabel setelah checkbox dipilih
function getDataFromTable(selectType) {
    selectedData = []; // Kosongkan selectedData sebelum mengambil data dari tabel
    $(".dataCheckbox:checked").each(function() {
    	let value = $(this).val();

    	let rowData = {
    		type: selectType,
    		kd_obat: value,
            // Bisa di tambahkan lagi properti lain yang di butuhkan dari tabel
    	};
    	selectedData.push(rowData);
    });
}

$('#displaying').on('click', '#print-laporan', function(e) {
   e.preventDefault();
	
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
            tableLaporan.hide('slow').fadeOut(1000);

            const tableData = response.data;
            let header = `
					
            `;

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
            </thead>`;

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
            <tfoot class="table-footer">
            <tr>
            <td colspan="4" class="float-right font-bold">Bogor, ${dateFormat()}</td>
            <td colspan="4" class="float-right font-bold">Mengetahui</td>
            </tr>
            <tr>
            <td colspan="4" class="name float-right font-bold">
            ${name}
            </td>
            </tr>
            </tfoot>
            `;

            table += '</table>';

            // Mengubah konten elemen "tableContainer" dengan tabel baru
            $('#tableContainer').html(table);

            // Memasukkan kembali konten elemen anak dengan id "tableContainerHeader"
            $('#tableContainer').prepend(tableContainerHeaderContent);

            // Mengubah properti "display" menjadi "flex" pada elemen anak dengan id "tableContainerHeader"
            $('#tableContainerHeader').css('display', 'flex');

            loading.classList.remove('hidden');
            loading.classList.add('block');

            setTimeout(() => {
               loading.classList.remove('block');
               loading.classList.add('hidden');
               generatePDF(response.data);
            }, 1000);
         }
      }
   });
});


function generatePDF() {  
	getCanvas().then(function (canvas) {  
		var img = canvas.toDataURL("image/png"),  
		doc = new jsPDF({  
			unit: 'px',  
			format: 'a4'  
		})
		doc.addImage(img, 'JPEG', 20, 20) 
		doc.save('laporan-eoq.pdf')
		container.width(cache_width)  
	});  
}  

function getCanvas() {  
	container.width((a4[0] * 1.33333) - 80).css('max-width', 'none')
	return html2canvas(container, {  
		imageTimeout: 500,  
		removeContainer: true  
	})
}