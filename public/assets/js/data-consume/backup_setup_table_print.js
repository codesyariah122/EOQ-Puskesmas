// Mengambil konten dari elemen dengan id "tableContainerHeader"
            let tableContainerHeaderContent = $('#tableContainerHeader').html();
           
            // hide table laporan
            // printLaporanBtn.hide('slow').fadeOut(1000);
            // closeSelectedBtn.removeClass('hidden');
            // tableLaporan.hide('slow').fadeOut(1000);

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