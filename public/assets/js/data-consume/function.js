/**
 * @author: Puji Ermanto <pujiermanto@gmail.com>
 * Desc: File ini merupakan serangkaian instruksi untuk melakukan manipulasi data dan element pada struktur html. Melakukan ajax request secara asynchronous, sehingga memungkinkan untuk menambahkan nilai visual pada user experience.
 * */

const formatIdr = (angka) => {
  const formatRupiah = new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
  }).format(angka);

  return formatRupiah;
};

const formatDateIndonesia = (dateString) => {
  // Mendapatkan objek Date dari string tanggal
  const date = new Date(dateString);

  // Mendapatkan komponen tanggal, bulan, dan tahun
  const day = date.getDate();
  const month = date.getMonth() + 1; // Ditambahkan 1 karena bulan dimulai dari 0
  const year = date.getFullYear();

  // Mengatur format tanggal menjadi "DD-MM-YYYY"
  const formattedDate = `${day.toString().padStart(2, "0")}-${month
    .toString()
    .padStart(2, "0")}-${year}`;

  return formattedDate;
};

const dateFormat = () => {
  const currentDate = new Date();
  const day = currentDate.getDate();
  const month = currentDate.toLocaleString("default", { month: "short" });
  const year = currentDate.getFullYear();

  return `${day} ${month} ${year}`;
};

const hitungTotal = (data) => {
  const total = Math.round(data.harga * data.jumlah);
  return formatIdr(total);
};

const hitungEconomics = (data) => {
  return Math.round(
    Math.sqrt((2 * (data.b_pesan * data.k_tahun)) / data.b_simpan)
  );
};

const hitungIntervalWaktu = (data) => {
  return Math.round(
    Math.sqrt((2 * data.b_pesan) / (data.b_simpan * data.k_tahun)) * 365
  );
};

const setUpPagination = (data) => {
  pagination.empty();
  paging.totalData = data.totalData;
  paging.countPage = data.countPage;
  paging.totalPage = data.totalPage;
  paging.aktifPage = data.aktifPage;

  const prevEl = document.createElement("li");
  const nextEl = document.createElement("li");
  prevEl.innerHTML = `
    <li><a href="#" class="page-link flex items-center justify-center px-3 h-8 ml-0 leading-tight border  rounded-l-lg  dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${
      paging.aktifPage > 1
        ? "bg-blue-50 border-blue-300 text-blue-600 cursor-pointer"
        : "bg-white border-gray-300 text-gray-500 cursor-not-allowed"
    }" data-num="${
    paging.aktifPage > 1 ? paging.aktifPage - 1 : paging.aktifPage - 1
  }"><i class="fa-solid fa-angle-left"></i>&nbsp;Previous</a></li>
    `;
  nextEl.innerHTML = `
    <li><a href="#" class="page-link flex items-center justify-center px-3 h-8 ml-0 leading-tight border  rounded-r-lg  dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${
      paging.aktifPage < paging.totalPage
        ? "bg-blue-50 border-blue-300 text-blue-600 cursor-pointer"
        : "bg-white border-gray-300 text-gray-500 cursor-not-allowed"
    }" data-num="${
    paging.aktifPage < paging.totalPage
      ? paging.aktifPage + 1
      : paging.aktifPage + 1
  }">Next&nbsp;<i class="fa-solid fa-angle-right"></i></a></li>
    `;

  pagination.append(prevEl);

  for (let i = 1; i <= paging.totalPage; i++) {
    let pageLink = $(
      `<li><a href="#" class="page-link flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${
        i == paging.aktifPage ? "cursor-not-allowed" : "cursor-pointer"
      }" data-num="${i}">${i}</a></li>`
    );
    if (i === paging.aktifPage) {
      pageLink
        .find("a")
        .addClass(
          "text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
        );
    }
    pagination.append(pageLink);
  }

  pagination.append(nextEl);
};

const logPembelian = () => {
  const endPoint = "/dashboard/log-pembelian";

  $.ajax({
    url: endPoint,
    type: "GET",
    dataType: "json",
  }).done(function (response) {
    console.log(response);
    if (response.empty) {
      let domEmptyEl = "";
      domEmptyEl += `
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
        <span class="font-medium">Ooops!</span> belum ada pembelian.
        </div>
        </div>
        `;
      alertEmpty.html(domEmptyEl);
      $("#pembelian-log").hide();
    }

    if (response.success) {
      $("#pembelian-log").show("slow");
      let domDataHTML = "";
      response.data.map((log) => {
        domDataHTML += `
          <li class="mb-6 ml-6">            
          <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
          <img class="rounded-full shadow-lg" src="${
            log.username === "staf01"
              ? "https://flowbite.com/docs/images/people/profile-picture-4.jpg"
              : "https://flowbite.com/docs/images/people/profile-picture-2.jpg"
          }" alt="${log.nm_lengkap} image"/>
          </span>
          <div class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
          <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
          ${formatDateIndonesia(log.tgl_beli)}</time>
          <div class="text-sm font-normal text-gray-500 dark:text-gray-300">${
            log.username
          } menambahkan pembelian obat ${
          log.nm_obat
        } <a href="#" class="font-semibold text-blue-600 dark:text-blue-500 hover:underline"></a> dengan kode beli <span class="bg-gray-100 text-gray-800 text-xs font-normal mr-2 px-2.5 py-0.5 rounded dark:bg-gray-600 dark:text-gray-300">${
          log.kd_beli
        }</span></div>
          </div>
          </li>  
          `;
      });
      domLogBeli.html(domDataHTML);
    }
  });
};

const getData = (type, data = null) => {
  let endPoint;
  switch (type) {
    case "jumlah-k-tahun":
      endPoint = `/check/${type}?kd_obat=${data.kd_obat}&k_tahun=${data.k_tahun}`;
      break;

    case "total-biaya":
      endPoint = `/check/${type}?nama=${data.nama}&biaya_bln=${data.biaya_bln}&jumlah=${data.jumlah}`;
      break;
    case "input-formula":
      endPoint = `/check/${type}?kd_obat=${data.kd_obat}`;
      break;
  }
  $.ajax({
    url: endPoint,
    type: "GET",
    dataType: "json",
    data: { data },
    success: function (response) {
      const result = response;
      switch (type) {
        case "jumlah-k-tahun":
          $('input[name="jumlah"]').val(
            result.data ? result.data : "Loading ..."
          );
          break;

        case "total-biaya":
          console.log(result.data);
          $('input[name="total"]').val(
            result.data ? result.data : "Loading ..."
          );
          break;

        case "input-formula":
          console.log("Kesini");
          const formula = result.data ? result?.data : "Loading ...";
          console.log(formula);
          $('input[name="k_tahun"]').val(formula?.k_tahun);
          $('input[name="b_simpan"]').val(formula?.b_simpan);
          $('input[name="b_pesan"]').val(formula?.b_pesan);
          break;
      }
    },
  });
};

const getAllData = (type, page = 1, keyword = "") => {
  const endPoint = `/lists/${type}?page=${page}${
    keyword ? "&keyword=" + keyword : ""
  }`;

  $.ajax({
    url: endPoint,
    type: "GET",
    dataType: "json",
    data: {},
    success: function (response) {
      let lists = response;

      if (lists.success) {
        let domDataHTML = "";

        switch (type) {
          case "data-user":
            const users = lists?.data;
            const sessionUser = lists?.session_user;

            users?.map((user) => {
              domDataHTML += `
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              ${user.kd_admin}
              </th>
              <td class="px-6 py-4">
              ${user.nm_lengkap}
              </td>
              <td class="px-6 py-4">
              ${user.alamat}
              </td>
              <td class="px-6 py-4">
              ${user.notlp}
              </td>
              <td class="px-6 py-4">
              ${user.username}
              </td>
              <td class="px-6 py-4">
              <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">${
                user.role
              }</span>
              </td>

              ${
                user.username !== sessionUser
                  ? `<td>
                <div class="flex justify-center space-x-4">
                <div>
                <button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${user.kd_admin}">
                <i class="fa-solid fa-pen-to-square"></i>
                </button>                                 
                </div>
                <div>
                <button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${user.kd_admin}">
                <i class="fa-solid fa-trash"></i>
                </button>
                </div>
                </div>
                </td>`
                  : ""
              }
              </tr>
              `;
            });
            break;

          case "data-obat":
            const obats = lists.data;
            console.log(obats);
            obats.map((obat) => {
              domDataHTML += `
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              ${obat.kd_obat}
              </th>
              <td class="px-6 py-4">
              ${obat.nm_obat}
              </td>
              <td class="px-6 py-4">
              ${obat.stok}
              </td>
              <td class="px-6 py-4">
              ${obat.isi}
              </td>
              <td class="px-6 py-4">
              <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">${
                obat.jenis_obat
              }</span>
              </td>
              <td class="px-6 py-4">
              ${formatIdr(obat.harga)}
              </td>
              <td class="px-6 py-4">
              ${obat.sisa_stok == null ? 0 : obat.sisa_stok}
              </td>
              <td class="px-6 py-4">
              ${obat.k_tahun ? obat.k_tahun : "-"}
              </td>
              <td>
              <div class="flex justify-center space-x-4">
              <div>
              <button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${
                obat.kd_obat
              }">
              <i class="fa-solid fa-pen-to-square"></i>
              </button>                                 
              </div>
              <div>
              <button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${
                obat.kd_obat
              }">
              <i class="fa-solid fa-trash"></i>
              </button>
              </div>
              </div>
              </td>
              </tr>
              `;
            });
            break;

          case "laporan-eoq":
            const reports = lists.data;
            reports.map((report) => {
              domDataHTML += `
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td>
              <div class="flex justify-center space-x-4">
              <div>
              <input id="default-checkbox" type="checkbox" value="${
                report.kd_obat
              }" class="dataCheckbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">                                
              </div>
              </div>
              </td>
              <td class="field-id hidden" data-id="${report.id}">
              ${report.id}
              </td>
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              ${report.kd_obat}
              </th>
              <td class="px-6 py-4">
              ${report.nm_obat}
              </td>
              <td class="px-6 py-4">${report.k_tahun}</td>
              <td class="px-6 py-4">
              ${formatIdr(report.b_simpan)}
              </td>
              <td class="px-6 py-4">
              ${formatIdr(report.b_pesan)}
              </td>
              <td class="px-6 py-4">
              <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
              ${report.jumlah_eoq} ${
                report.jenis_obat === "CAIR"
                  ? "Botol"
                  : report.jenis_obat === "TABLET"
                  ? "Tablet"
                  : report.jenis_obat
              }
              </span>
              </td>
              <td class="px-6 py-4">
              <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
              ${report.intval_time} Hari
              </span>
              </td>
              </tr>
              `;
            });
            break;

          case "laporan-pembelian":
            const reportsbeli = lists.data;
            reportsbeli.map((report) => {
              domDataHTML += `
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td>
              <div class="flex justify-center space-x-4">
              <div>
              <input class="default-checkbox dataCheckbox" type="checkbox" value="${
                report.kd_obat
              }" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">                                
              </div>
              </div>
              </td>
              <td class="field-id hidden" data-id="${report.id}">
              ${report.id}
              </td>
              <th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">

              <div class="kd_beli">${report.kd_beli}</div>
              <button type="button" class="copyButton text-gray-700 border-none hover:bg-gray-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" data-kode="${
                report.kd_beli
              }">
              <i class="fa-solid fa-clipboard"></i>
              <span class="sr-only">Icon description</span>
              </button>
              </th>
              <td class="px-6 py-4">
              ${formatDateIndonesia(report.tgl_beli)}
              </td>
              <td class="px-6 py-4">${report.kd_obat}</td>
              <td class="px-6 py-4">${report.nm_obat}</td>
              <td class="px-6 py-4">${report.jumlah}</td>
              <td class="px-6 py-4">
              ${formatIdr(report.harga)}
              </td>
              <td class="px-6 py-4">
              ${hitungTotal({ harga: report.harga, jumlah: report.jumlah })}
              </td>

              </tr>
              `;
            });
            break;

          case "pembelian":
            const listsBeli = lists.data;
            console.log(listsBeli);
            listsBeli.map((report) => {
              domDataHTML += `
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="field-id hidden" data-id="${report.id}">
              ${report.id}
              </td>
              <th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">

              <div class="kd_beli">${report.kd_beli}</div>
              <button type="button" class="copyButton text-gray-700 border-none hover:bg-gray-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" data-kode="${
                report.kd_beli
              }">
              <i class="fa-solid fa-clipboard"></i>
              <span class="sr-only">Icon description</span>
              </button>
              </th>
              <td class="px-6 py-4">
              ${formatDateIndonesia(report.tgl_beli)}
              </td>
              <td class="px-6 py-4">${report.kd_obat}</td>
              <td class="px-6 py-4">${report.nm_obat}</td>
              <td class="px-6 py-4">${report.jumlah}</td>
              <td class="px-6 py-4">
              ${formatIdr(report.harga)}
              </td>
              <td class="px-6 py-4">
              ${hitungTotal({ harga: report.harga, jumlah: report.jumlah })}
              </td>
              <td>
              <div class="flex justify-center space-x-4">
              <div>
              <button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${
                report.kd_beli
              }">
              <i class="fa-solid fa-pen-to-square"></i>
              </button>                                 
              </div>
              <div>
              <button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${
                report.kd_beli
              }">
              <i class="fa-solid fa-trash"></i>
              </button>
              </div>
              </div>
              </td>
              </tr>
              `;
            });
            break;

          case "biaya":
            const listsBiaya = lists.data;
            listsBiaya.map((report) => {
              domDataHTML += `
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="field-id hidden" data-id="${report.id}">
              ${report.id}
              </td>
              <th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">
              ${report.nama}
              </th>
              <td class="px-6 py-4">
              ${formatIdr(report.biaya_bln)}
              </td>
              <td class="px-6 py-4">${report.jumlah}</td>
              <td class="px-6 py-4">
              ${formatIdr(report.total)}
              </td>
              <td>
              <div class="flex justify-center space-x-4">
              <div>
              <button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${
                report.id
              }">
              <i class="fa-solid fa-pen-to-square"></i>
              </button>                                 
              </div>
              <div>
              <button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${
                report.id
              }">
              <i class="fa-solid fa-trash"></i>
              </button>
              </div>
              </div>
              </td>
              </tr>
              `;
            });
            break;

          case "kebutuhan-pertahun":
            const listsKebutuhan = lists.data;
            listsKebutuhan.map((report) => {
              domDataHTML += `
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="field-id hidden" data-id="${report.needs_id}">
              ${report.id}
              </td>
              <th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">
              ${report.nm_obat}
              </th>
              <td class="px-6 py-4">
              ${report.k_tahun}
              </td>
              <td class="px-6 py-4">
              ${report.satuan}
              </td>
              <td class="px-6 py-4">${formatIdr(report.jumlah)}</td>
              <td>
              <div class="flex justify-center space-x-4">
              <div>
              <button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${
                report.needs_id
              }">
              <i class="fa-solid fa-pen-to-square"></i>
              </button>                                 
              </div>
              <div>
              <button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${
                report.needs_id
              }">
              <i class="fa-solid fa-trash"></i>
              </button>
              </div>
              </div>
              </td>
              </tr>
              `;
            });
            break;
          // type lainnya ....

          default:
        }

        // Append data to element dom
        domDataLists.html(domDataHTML);

        // pagination
        setUpPagination(lists);
      } else {
        domDataLists.html("");
      }
    },
  });
};

const searchData = (param, type) => {
  let endPoint = "";
  let prepareData;

  switch (type) {
    case "data-user":
      endPoint = `/lists/${type}?keyword=${param.data}`;
      prepareData = {
        keyword: param.data,
      };
      break;
    case "data-obat":
      endPoint = `/lists/${type}?keyword=${param.data}`;
      prepareData = {
        keyword: param.data,
      };
      break;

    case "laporan-eoq":
      endPoint = `/lists/${type}?keyword=${param.data}`;
      prepareData = {
        keyword: param.data,
      };
      break;

    case "laporan-pembelian":
      endPoint = `/lists/${type}?keyword=${param.data}`;
      prepareData = {
        keyword: param.data,
      };
      break;

    case "pembelian":
      endPoint = `/lists/${type}?keyword=${param.data}`;
      prepareData = {
        keyword: param.data,
      };
      break;

    case "biaya":
      endPoint = `/lists/${type}?keyword=${param.data}`;
      prepareData = {
        keyword: param.data,
      };
      break;
    // type lainnya ...

    default:
  }

  $.ajax({
    url: endPoint,
    type: "GET",
    dataType: "json",
    startTime: new Date().getTime(),
    success: function (response) {
      let lists = response;

      let domDataHTML = "";

      if (lists.success) {
        switch (type) {
          case "data-user":
            const users = lists?.data;
            const sessionUser = lists?.session_user;

            users?.map((user) => {
              domDataHTML += `
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            ${user.kd_admin}
            </th>
            <td class="px-6 py-4">
            ${user.nm_lengkap}
            </td>
            <td class="px-6 py-4">
            ${user.alamat}
            </td>
            <td class="px-6 py-4">
            ${user.notlp}
            </td>
            <td class="px-6 py-4">
            ${user.username}
            </td>

            ${
              user.username !== sessionUser
                ? `<td>
              <div class="flex justify-center space-x-4">
              <div>
              <button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${user.kd_admin}">
              <i class="fa-solid fa-pen-to-square"></i>
              </button>                                 
              </div>
              <div>
              <button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${user.kd_admin}">
              <i class="fa-solid fa-trash"></i>
              </button>
              </div>
              </div>
              </td>`
                : ""
            }
            </tr>
            `;
            });
            break;

          case "data-obat":
            const obats = lists.data;

            obats.map((obat) => {
              domDataHTML += `
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              ${obat.kd_obat}
              </th>
              <td class="px-6 py-4">
              ${obat.nm_obat}
              </td>
              <td class="px-6 py-4">
              ${obat.stok}
              </td>
              <td class="px-6 py-4">
              ${obat.isi}
              </td>
              <td class="px-6 py-4">
              <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">${
                obat.jenis_obat
              }</span>
              </td>
              <td class="px-6 py-4">
              ${formatIdr(obat.harga)}
              </td>
              <td class="px-6 py-4">
              ${obat.sisa_stok == null ? 0 : obat.sisa_stok}
              </td>
              <td>
              <div class="flex justify-center space-x-4">
              <div>
              <button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${
                obat.kd_obat
              }">
              <i class="fa-solid fa-pen-to-square"></i>
              </button>                                 
              </div>
              <div>
              <button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${
                obat.kd_obat
              }">
              <i class="fa-solid fa-trash"></i>
              </button>
              </div>
              </div>
              </td>
              </tr>
              `;
            });
            break;

          case "laporan-eoq":
            const reports = lists.data;
            reports.map((report) => {
              domDataHTML += `
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td>
            <div class="flex justify-center space-x-4">
            <div>
            <td class="field-id hidden" data-id="${report.id}">
            ${report.id}
            </td>
            <input id="default-checkbox" type="checkbox" value="${
              report.kd_obat
            }" class="dataCheckbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">                                
            </div>
            </div>
            </td>
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            ${report.kd_obat}
            </th>
            <td class="px-6 py-4">
            ${report.nm_obat}
            </td>
            <td class="px-6 py-4">${report.k_tahun}</td>
            <td class="px-6 py-4">
            ${formatIdr(report.b_simpan)}
            </td>
            <td class="px-6 py-4">
            ${formatIdr(report.b_pesan)}
            </td>
            <td class="px-6 py-4">
            <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
            ${report.jumlah_eoq} ${
                report.jenis_obat === "CAIR"
                  ? "Botol"
                  : report.jenis_obat === "TABLET"
                  ? "Strip"
                  : report.jenis_obat
              }
            </span>
            </td>
            <td class="px-6 py-4">
            <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
            ${report.intval_time} Hari
            </span>
            </td>
            </tr>
            `;
            });
            break;

          case "laporan-pembelian":
            const reportsbeli = lists.data;
            reportsbeli.map((report) => {
              domDataHTML += `
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td>
            <div class="flex justify-center space-x-4">
            <div>
            <input class="default-checkbox dataCheckbox" type="checkbox" value="${
              report.kd_obat
            }" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">                                
            </div>
            </div>
            </td>
            <td class="field-id hidden" data-id="${report.id}">
            ${report.id}
            </td>
            <th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">

            <div class="kd_beli">${report.kd_beli}</div>
            <button type="button" class="copyButton text-gray-700 border-none hover:bg-gray-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" data-kode="${
              report.kd_beli
            }">
            <i class="fa-solid fa-clipboard"></i>
            <span class="sr-only">Icon description</span>
            </button>
            </th>
            <td class="px-6 py-4">
            ${formatDateIndonesia(report.tgl_beli)}
            </td>
            <td class="px-6 py-4">${report.kd_obat}</td>
            <td class="px-6 py-4">${report.nm_obat}</td>
            <td class="px-6 py-4">${report.jumlah}</td>
            <td class="px-6 py-4">
            ${formatIdr(report.harga)}
            </td>
            <td class="px-6 py-4">
            ${hitungTotal({ harga: report.harga, jumlah: report.jumlah })}
            </td>

            </tr>
            `;
            });
            break;

          case "pembelian":
            const listsBeli = lists.data;
            listsBeli.map((report) => {
              domDataHTML += `
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="field-id hidden" data-id="${report.id}">
            ${report.id}
            </td>
            <th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">

            <div class="kd_beli">${report.kd_beli}</div>
            <button type="button" class="copyButton text-gray-700 border-none hover:bg-gray-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" data-kode="${
              report.kd_beli
            }">
            <i class="fa-solid fa-clipboard"></i>
            <span class="sr-only">Icon description</span>
            </button>
            </th>
            <td class="px-6 py-4">
            ${formatDateIndonesia(report.tgl_beli)}
            </td>
            <td class="px-6 py-4">${report.kd_obat}</td>
            <td class="px-6 py-4">${report.nm_obat}</td>
            <td class="px-6 py-4">${report.jumlah}</td>
            <td class="px-6 py-4">
            ${formatIdr(report.harga)}
            </td>
            <td class="px-6 py-4">
            ${hitungTotal({ harga: report.harga, jumlah: report.jumlah })}
            </td>
            <td>
            <div class="flex justify-center space-x-4">
            <div>
            <button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${
              report.kd_obat
            }">
            <i class="fa-solid fa-pen-to-square"></i>
            </button>                                 
            </div>
            <div>
            <button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${
              report.kd_obat
            }">
            <i class="fa-solid fa-trash"></i>
            </button>
            </div>
            </div>
            </td>
            </tr>
            `;
            });
            break;

          case "biaya":
            const listsBiaya = lists.data;
            listsBiaya.map((report) => {
              domDataHTML += `
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="field-id hidden" data-id="${report.id}">
            ${report.id}
            </td>
            <th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">
            ${report.biaya}
            </th>
            <td class="px-6 py-4">
            ${report.biaya_bln}
            </td>
            <td class="px-6 py-4">${formatIdr(report.jumlah)}</td>
            <td class="px-6 py-4">
            ${formatIdr(report.total)}
            </td>
            <td>
            <div class="flex justify-center space-x-4">
            <div>
            <button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${
              report.id
            }">
            <i class="fa-solid fa-pen-to-square"></i>
            </button>                                 
            </div>
            <div>
            <button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${
              report.id
            }">
            <i class="fa-solid fa-trash"></i>
            </button>
            </div>
            </div>
            </td>
            </tr>
            `;
            });
            break;

          case "kebutuhan-pertahun":
            const listsKebutuhan = lists.data;
            listsKebutuhan.map((report) => {
              domDataHTML += `
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="field-id hidden" data-id="${report.id}">
            ${report.id}
            </td>
            <th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">
            ${report.nm_obat}
            </th>
            <td class="px-6 py-4">
            ${report.k_tahun}
            </td>
            <td class="px-6 py-4">
            ${report.satuan}
            </td>
            <td class="px-6 py-4">${formatIdr(report.jumlah)}</td>
            <td>
            <div class="flex justify-center space-x-4">
            <div>
            <button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${
              report.id
            }">
            <i class="fa-solid fa-pen-to-square"></i>
            </button>                                 
            </div>
            <div>
            <button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${
              report.id
            }">
            <i class="fa-solid fa-trash"></i>
            </button>
            </div>
            </div>
            </td>
            </tr>
            `;
            });
            break;
          // type lainnya ....

          default:
        }

        domDataLists.html(domDataHTML);

        setUpPagination(lists);
      } else {
        if (lists.empty) {
          domDataHTML += `
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <th scope="row" colspan="2" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          ${lists.message}
          </th>
          </tr>
          `;
          domDataLists.html(domDataHTML);
        }
      }
    },
  });
};

const addData = (param, type) => {
  let endPoint = `/add/${type}`;
  let prepareData = {};

  switch (type) {
    case "data-user":
      prepareData = {
        nm_lengkap: param.data.nm_lengkap,
        password: param.data.password,
        alamat: param.data.alamat,
        notlp: param.data.notlp,
        role: param.data.role,
      };
      break;

    case "data-obat":
      prepareData = {
        nm_obat: param.data.nm_obat,
        isi: param.data.isi,
        satuan: param.data.satuan,
        jenis_obat: param.data.jenis_obat,
        harga: param.data.harga,
        stok: param.data.stok,
      };
      break;

    case "pengajuan-obat":
      prepareData = {
        kd_obat: param.data.kd_obat,
        k_tahun: param.data.k_tahun,
        b_simpan: param.data.b_simpan,
        b_pesan: param.data.b_pesan,
      };
      break;

    case "pembelian":
      prepareData = {
        kd_obat: param.data.kd_obat,
        jumlah: param.data.jumlah,
      };
      break;
    case "kebutuhan-pertahun":
      prepareData = {
        kd_obat: param.data.kd_obat,
        k_tahun: param.data.k_tahun,
        jumlah: param.data.jumlah,
      };
      break;

    case "biaya":
      prepareData = {
        nama: param.data.nama,
        biaya_bln: param.data.biaya_bln,
        jumlah: param.data.jumlah,
        total: param.data.total,
      };
      break;
    // type lainnya ...

    default:
  }
  // console.log(endPoint);

  $.ajax({
    url: endPoint,
    type: "POST",
    dataType: "json",
    data: prepareData,
    startTime: new Date().getTime(),
    success: function (response) {
      const responseData = response;

      let time = new Date().getTime() - this.startTime;

      if (responseData.error) {
        alertSuccess.hide();
        messageSuccess.html("");
        loadingBtn.addClass("hidden");
        textBtn.removeClass("hidden");
        alertError.show();
        messageError.html(`
         <span class="font-medium"> Ooops!</span>${responseData.message}!
         `);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: responseData.message,
        });
      }

      if (responseData.success) {
        alertError.hide();
        messageError.html("");
        console.log("This request took " + time + " ms");

        switch (type) {
          case "data-user":
            $('input[name="nm_lengkap"]').val("");
            $('textarea[name="alamat"]').val("");
            $('input[name="notlp"]').val("");
            $('input[name="password"]').val("");
            $("#role").val("Pilih Role");
            setTimeout(() => {
              alertSuccess.show();
              messageSuccess.html(`
             <span class="font-medium"> Berhasil menambah pengguna baru!</span> ${responseData.message}
             `);

              loadingBtn.addClass("hidden");
              textBtn.removeClass("hidden");
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: responseData.message,
                showConfirmButton: false,
                timer: 1500,
              });
            }, 1000);
            break;

          case "data-obat":
            $('input[name="nm_obat"]').val("");
            $("#jenis_obat").val("Pilih Jenis Obat");
            $('input[name="harga"]').val("");
            $('input[name="stok"]').val("");
            setTimeout(() => {
              alertSuccess.show();
              // messageSuccess.html(`
              // <span class="font-medium"> Berhasil menambah data obat baru!</span> ${responseData.message}
              // `);

              loadingBtn.addClass("hidden");
              textBtn.removeClass("hidden");
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: responseData.message,
                showConfirmButton: false,
                timer: 1500,
              });
            }, 1000);
            break;

          case "pengajuan-obat":
            kd_obatOption = null;
            $('input[name="k_tahun"]').val("");
            $('input[name="b_simpan"]').val("");
            $('input[name="b_pesan"]').val("");
            $("#selectOption").val(null).trigger("change");
            setTimeout(() => {
              alertSuccess.show();
              messageSuccess.html(`
             <span class="font-medium"> Berhasil menambah data pengajuan obat baru!</span> ${responseData.message}`);

              loadingBtn.addClass("hidden");
              textBtn.removeClass("hidden");
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: responseData.message,
                showConfirmButton: false,
                timer: 1500,
              });
            }, 1000);
            break;

          case "pembelian":
            kd_obatOption = "";
            $('input[name="jumlah"]').val("");
            setTimeout(() => {
              alertSuccess.show();
              messageSuccess.html(`
             <span class="font-medium"> Pembelian baru berhasil!</span> ${responseData.message}`);
              kd_obatOption = null;
              $("#selectOption").val(null).trigger("change");
              loadingBtn.addClass("hidden");
              textBtn.removeClass("hidden");
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: responseData.message,
                showConfirmButton: false,
                timer: 1500,
              });
            }, 1000);
            const chartUpdateEvent = new Event("chart-updated");
            document.dispatchEvent(chartUpdateEvent);
            $("#alert-empty").hide();
            logPembelian();
            break;

          case "kebutuhan-pertahun":
            kd_obatOption = null;
            $('input[name="k_tahun"]').val("");
            $('input[name="jumlah"]').val("");
            $("#selectOption").val(null).trigger("change");
            setTimeout(() => {
              alertSuccess.show();
              messageSuccess.html(`
             <span class="font-medium"> Berhasil menambah data !</span> ${responseData.message}`);

              loadingBtn.addClass("hidden");
              textBtn.removeClass("hidden");
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: responseData.message,
                showConfirmButton: false,
                timer: 1500,
              });
            }, 1000);
            break;

          case "biaya":
            $('input[name="nama"]').val("");
            $('input[name="biaya_bln"]').val("");
            $('input[name="jumlah"]').val("");
            $('input[name="total"]').val("");
            setTimeout(() => {
              alertSuccess.show();
              messageSuccess.html(`
             <span class="font-medium"> Berhasil menambah data !</span> ${responseData.message}
             &nbsp;<br/>`);

              loadingBtn.addClass("hidden");
              textBtn.removeClass("hidden");
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: responseData.message,
                showConfirmButton: false,
                timer: 1500,
              });
            }, 1000);
            break;
          // type lainnya
        }
        if (pagePath !== "pengajuan-obat") {
          getAllData(type, 1);
        }
      }
    },
  });
};

const updateData = (param, type) => {
  let endPoint = "";
  let prepareData = {};
  switch (type) {
    case "data-user":
      endPoint = `/update/${type}/${param.id}`;
      prepareData = {
        kd_admin: param.data.kd_admin,
        nm_lengkap: param.data.nm_lengkap,
        alamat: param.data.alamat,
        notlp: param.data.notlp,
        username: param.data.username,
        password: param.data.password,
        new_password: param.data.new_password,
      };
      break;

    case "data-obat":
      endPoint = `/update/${type}/${param.id}`;
      prepareData = {
        kd_obat: param.data.kd_obat,
        nm_obat: param.data.nm_obat,
        jenis_obat: param.data.jenis_obat,
        harga: param.data.harga,
        stok: param.data.stok,
      };
      break;

    case "pembelian":
      endPoint = `/update/${type}/${param.id}`;
      prepareData = {
        kd_beli: param.data.kd_beli,
        kd_obat: param.data.kd_obat,
        tgl_beli: param.data.tgl_beli,
        jumlah: param.data.jumlah,
      };
      break;

    case "biaya":
      endPoint = `/update/${type}/${param.id}`;
      prepareData = {
        id: param.data.id,
        nama: param.data.nama,
        biaya_bln: param.data.biaya_bln,
        jumlah: param.data.jumlah,
        total: param.data.total,
      };
      break;

    case "kebutuhan-pertahun":
      endPoint = `/update/${type}/${param.id}`;
      prepareData = {
        id: param.data.id,
        kd_obat: param.data.kd_obat,
        k_tahun: param.data.k_tahun,
        jumlah: param.data.jumlah,
      };
      break;
    // type lainnya ....

    default:
  }

  $.ajax({
    url: endPoint,
    type: "POST",
    dataType: "json",
    data: prepareData,
    startTime: new Date().getTime(),
    success: function (response) {
      const responseData = response;

      let time = new Date().getTime() - this.startTime;

      if (responseData.error) {
        alertSuccess.hide();
        messageSuccess.html("");
        loadingBtn.addClass("hidden");
        textBtn.removeClass("hidden");
        alertError.show();
        messageError.html(`
         <span class="font-medium"> Ooops!</span>${responseData.message}!
         `);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: responseData.message,
        });
        loading.classList.remove("block");
        loading.classList.add("hidden");
      }

      if (responseData.success) {
        console.log("This request took " + time + " ms");

        setTimeout(() => {
          alertSuccess.show();
          messageSuccess.html(`
            <span class="font-medium"> Update successfully!</span> ${responseData.message}
            `);

          loadingBtn.addClass("hidden");
          textBtn.removeClass("hidden");
          loading.classList.remove("block");
          loading.classList.add("hidden");
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: responseData.message,
            showConfirmButton: false,
            timer: 1500,
          });

          history.go(-1);
        }, 1000);
      }
    },
  });
};

const deleteData = (param, type) => {
  let endPoint = `/delete/${type}/${param.id}`;

  $.ajax({
    url: endPoint,
    type: "DELETE",
    dataType: "json",
    data: `${param.field}=${param.id}`,
    startTime: new Date().getTime(),
    success: function (response) {
      console.log(paging.aktifPage);
      const responseData = response;

      let time = new Date().getTime() - this.startTime;

      if (responseData.success) {
        console.log("This request took " + time + " ms");

        setTimeout(() => {
          loading.classList.remove("block");
          loading.classList.add("hidden");
          getAllData(type, paging.aktifPage);
          logPembelian();
          alertSuccess.show();
          messageSuccess.html(`
            <span class="font-medium"> Deleted successfully!</span> ${responseData.message}
            `);
          loadingBtn.addClass("hidden");
          textBtn.removeClass("hidden");
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: responseData.message,
            showConfirmButton: false,
            timer: 1500,
          });
        }, 1000);
      }
    },
  });
};

function showToast(message) {
  const toastContainer = document.getElementById("toastContainer");

  // Create toast element
  const toast = document.createElement("div");
  toast.classList.add("toast");
  toast.innerHTML = message;

  // Add toast to container
  toastContainer.appendChild(toast);

  // Show toast
  toast.classList.add("show");

  // Auto hide after 3 seconds
  setTimeout(() => {
    toast.classList.add("hide");
    setTimeout(() => {
      // Remove toast from container
      toastContainer.removeChild(toast);
    }, 300);
  }, 3000);
}

// function loadAndInitializeSelect2() {
// 	$.ajax({
// 		url: $('#selectOption').data('action'),
// 		dataType: 'json',
// 		delay: 100,
// 		processResults: function(data) {
// 			console.log(data)
// 			return {
// 				results: data
// 			};
// 		},
// 		success: function(data) {
// 			$('#selectOption').select2({
// 				placeholder: 'Pilih Obat',
// 				allowClear: true,
// 				data: data,
// 				cache: true
// 			});
// 		}
// 	});
// }

function loadInitializeSelect2Edit() {
  const id_obat = $("#selectEdit").data("id");
  const kd_obat = $("#selectEdit").data("kode");
  const nm_obat = $("#selectEdit").data("nama");

  $("#selectEdit").select2({
    placeholder: kd_obat,
    allowClear: true,
    ajax: {
      url: $("#selectEdit").data("action"),
      dataType: "json",
      delay: 100,
      processResults: function (data) {
        return {
          results: data,
        };
      },
      cache: true,
    },
    dropdownPosition: "below",
  });

  $.ajax({
    url: $("#selectEdit").data("action"),
    dataType: "json",
    success: function (data) {
      let defaultOption = new Option(nm_obat, id_obat, "", true, true);
      $("#selectEdit").append(defaultOption);

      // Tambahkan data dari response
      $.each(data, function (index, item) {
        var option = new Option(item.text, item.id, false, false);
        $("#selectEdit").append(option);
      });

      // Inisialisasi ulang Select2
      $("#selectEdit").trigger("change");
    },
  });
}

function loadAndInitializeSelect2() {
  $("#selectOption").select2({
    placeholder: "Pilih Obat",
    allowClear: true,
    ajax: {
      url: $("#selectOption").data("action"),
      dataType: "json",
      delay: 100,
      processResults: function (data) {
        return {
          results: data,
        };
      },
      cache: true,
    },
    dropdownPosition: "below",
  });

  $.ajax({
    url: $("#selectOption").data("action"),
    dataType: "json",
    success: function (data) {
      // Buat opsi default
      let defaultOption = new Option("Pilih Obat", "", true, true);
      $("#selectOption").append(defaultOption);

      // Tambahkan data dari response
      $.each(data, function (index, item) {
        var option = new Option(item.text, item.id, false, false);
        $("#selectOption").append(option);
      });

      // Inisialisasi ulang Select2
      $("#selectOption").trigger("change");
    },
  });
}

const changeSingleDate = () => {
  const dateRangePickerEl = document.querySelector("#tgl_beli").value;
  console.log(dateRangePickerEl);
};
