$(document).ready(function () {
  $("#displaying").on("click", ".change__input-date", function (e) {
    $("#single").toggle();
    $("#multiple").toggleClass("hidden");
  });

  $("#displaying").on("change", "#jenis_obat", function (e) {
    e.preventDefault();
    const jenis_obat = $(this).val();
    const satuan_isi = $("#satuan_isi").val("box");
    switch (jenis_obat) {
      case "TABLET":
        console.log(satuan_isi.val());
        break;
    }
  });

  $("#displaying").on("input", "#k_tahun", function (e) {
    e.preventDefault();
    const kd_obatEdit = $("#selectEdit").data("kode");
    const k_tahun = Number($('input[name="k_tahun"]').val());
    const kd_obat = kd_obatOption !== null ? kd_obatOption : kd_obatEdit;
    const param = {
      k_tahun: k_tahun,
      kd_obat: kd_obat,
    };

    if (kd_obat === null) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Pilih data obat terlebih dahulu!",
      });
    }

    getData("jumlah-k-tahun", param);
  });

  $("#displaying").on("input", "#jumlah", function (e) {
    e.preventDefault();
    const nama = $('input[name="nama"]').val();
    const biaya_bln = Number($('input[name="biaya_bln"]').val());
    const jumlah = $('input[name="jumlah"]').val();

    const param = {
      nama: nama,
      biaya_bln: biaya_bln,
      jumlah: jumlah,
    };

    if (nama === null || biaya_bln === null || jumlah === null) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Pilih data obat terlebih dahulu!",
      });
    }

    getData("total-biaya", param);
  });

  $("#displaying").on("click", "#togglePassword", function (e) {
    e.preventDefault();
    const passwordInput = $("#passwordInput").attr("type");
    const icon = $(".icon-password");

    if (passwordInput === "password") {
      $("#passwordInput").attr("type", "text");
      icon.removeClass("fa-eye");
      icon.addClass("fa-eye-slash");
    } else {
      $("#passwordInput").attr("type", "password");
      icon.removeClass("fa-eye-slash");
      icon.addClass("fa-eye");
    }
  });

  $("#displaying").on("click", "#toggleNewPassword", function (e) {
    e.preventDefault();
    const passwordInput = $("#newPasswordInput").attr("type");
    const icon = $(".icon-new-password");

    if (passwordInput === "password") {
      $("#newPasswordInput").attr("type", "text");
      icon.removeClass("fa-eye");
      icon.addClass("fa-eye-slash");
    } else {
      $("#newPasswordInput").attr("type", "password");
      icon.removeClass("fa-eye-slash");
      icon.addClass("fa-eye");
    }
  });

  // Toast copy kd_beli
  $("#displaying").on("click", ".close-toast", function () {
    $("#toast-success").addClass("hidden");
    $("#toast-success").hide("slow").fadeOut(1000);
  });

  $("#displaying").on("click", ".copyButton", function () {
    let kode = $(this).data("kode");
    let toast = $(`.toast-${kode}`);
    let textToCopy = $(this).prev(".kd_beli")[0];
    let range = document.createRange();
    range.selectNode(textToCopy);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);

    try {
      document.execCommand("copy");
      showToast(
        `<i class="fa-solid fa-check"></i> Kode Beli ${kode} berhasil di copy`
      );
      // alert(`Kode ${kode} berhasil disalin: ${textToCopy.textContent}`);
    } catch (err) {
      console.error("Gagal menyalin teks ke clipboard:", err);
    }

    window.getSelection().removeAllRanges();
  });

  // Check checkbox displaying data laporan
  $("#displaying").on("change", ".checkAll", function (e) {
    e.preventDefault();
    container.show().fadeIn(1000);
    let isChecked = $(this).prop("checked");
    $(".dataCheckbox").prop("checked", isChecked);

    // Perbarui status checkbox individu
    $(".dataCheckbox").each(function () {
      $(this).prop("checked", isChecked);
    });

    // Panggil fungsi getDataFromTable untuk mengambil data dari tabel
    getDataFromTable("checkAll"); // Panggil dengan selectType 'checkAll'
  });

  $("#displaying").on("change", ".dataCheckbox", function () {
    container.show().fadeIn(1000);

    if ($(".dataCheckbox:checked").length === $(".dataCheckbox").length) {
      $("#checkAll").prop("checked", true);
    } else {
      $("#checkAll").prop("checked", false);
    }
    // Panggil fungsi getDataFromTable untuk mengambil data dari tabel
    getDataFromTable("checkIndividual"); // Panggil dengan selectType 'checkIndividual'
  });

  // Pagination displaying data consume
  $("#displaying").on("click", ".page-link", function (e) {
    e.preventDefault();
    const keyword = $("#search-data").val();
    const pageNum = $(this).data("num");

    if (keyword) {
      getAllData(pagePath, pageNum, keyword);
    } else {
      getAllData(pagePath, pageNum, keyword);
    }
  });

  // Search displaying data consume
  $("#displaying").on("keyup", "#search-data", function (e) {
    e.preventDefault();
    const keyword = e.target.value;
    const param = {
      data: keyword,
    };

    searchData(param, pagePath);
  });

  // Close pdf selected
  $("#displaying").on("click", "#close-selected", function (e) {
    // 	e.preventDefault()
    // 	container.hide('slow').fadeOut(1000)
    // 	tableLaporan.removeClass('hidden')
    // 	tableLaporan.show().fadeIn(1000)
    // 	printLaporanBtn.show().fadeIn(1000)
    // 	closeSelectedBtn.hide('slow').fadeOut(1000)
    // 	closeSelectedBtn.addClass('hidden')
    // 	container.hide('slow').fadeOut(1000)
    // 	$('.dom-laporan-table').remove()
    // 	$('#tableContainerHeader').removeClass('hidden')
    // 	$(".dataCheckbox").prop("checked", false);
    // 	$(".checkAll").prop("checked", false);
    // 	selectedData = [];

    // 	// Mengambil konten dari elemen dengan id "tableContainerHeader"
    // 	let tableContainerHeaderContent = $('#tableContainerHeader').html();

    // // Memasukkan kembali konten elemen anak dengan id "tableContainerHeader"
    // 	$('#tableContainer').prepend(tableContainerHeaderContent);

    // // Mengubah properti "display" menjadi "flex" pada elemen anak dengan id "tableContainerHeader"
    // 	$('#tableContainerHeader').css('display', 'flex');

    location.reload();
  });

  // add displaying data consume
  $("#displaying").on("click", ".add", function (e) {
    e.preventDefault();

    loadingBtn.removeClass("hidden");
    textBtn.addClass("hidden");

    let prepareData = {};
    console.log(pagePath);

    switch (pagePath) {
      case "data-user":
        prepareData = {
          nm_lengkap: $('input[name="nm_lengkap"]').val(),
          password: $('input[name="password"]').val(),
          alamat: $('textarea[name="alamat"]').val(),
          notlp: $('input[name="notlp"]').val(),
          role: $("#role").val(),
        };
        break;

      case "data-obat":
        prepareData = {
          nm_obat: $('input[name="nm_obat"]').val(),
          isi: $('input[name="isi"]').val(),
          satuan: $("#satuan_isi").val(),
          jenis_obat: $("#jenis_obat").val(),
          harga: $('input[name="harga"]').val(),
          stok: $('input[name="stok"]').val(),
        };
        break;

      case "pengajuan-obat":
        prepareData = {
          kd_obat: kd_obatOption,
          k_tahun: $('input[name="k_tahun"]').val(),
          b_simpan: $('input[name="b_simpan"]').val(),
          b_pesan: $('input[name="b_pesan"]').val(),
        };
        break;

      case "pembelian":
        prepareData = {
          kd_obat: kd_obatOption,
          jumlah: $('input[name="jumlah"]').val(),
        };
        break;

      case "kebutuhan-pertahun":
        prepareData = {
          kd_obat: kd_obatOption,
          k_tahun: Number($('input[name="k_tahun"]').val()),
          jumlah: Number($('input[name="jumlah"]').val()),
        };
        console.log(prepareData);
        break;
      case "biaya":
        prepareData = {
          nama: $('input[name="nama"]').val(),
          biaya_bln: Number($('input[name="biaya_bln"]').val()),
          jumlah: Number($('input[name="jumlah"]').val()),
          total: Number($('input[name="total"]').val()),
        };
        console.log(prepareData);
        break;

      default:
        console.log("No type");
    }

    const param = {
      data: prepareData,
    };

    addData(param, pagePath);
  });

  // edit data-user
  $("#displaying").on("click", ".edit", function () {
    const kd_data = $(this).attr("data-id");
    location.href = `/dashboard/${pagePath}/${kd_data}`;
  });

  // Update displaying data consume
  $("#displaying").on("click", ".update", function (e) {
    e.preventDefault();
    loading.classList.remove("hidden");
    loading.classList.add("block");
    loadingBtn.removeClass("hidden");
    textBtn.addClass("hidden");
    let prepareData = {};
    let id = null;

    switch (pagePath) {
      case "data-user":
        prepareData = {
          kd_admin: $('input[name="kd_admin"]').val(),
          nm_lengkap: $('input[name="nm_lengkap"]').val(),
          alamat: $('textarea[name="alamat"]').val(),
          notlp: $('input[name="notlp"]').val(),
          username: $('input[name="username"]').val(),
          password: $('input[name="password"]').val(),
          new_password: $('input[name="new_password"]').val(),
        };
        id = prepareData.kd_admin;
        break;

      case "data-obat":
        prepareData = {
          kd_obat: $('input[name="kd_obat"]').val(),
          nm_obat: $('input[name="nm_obat"]').val(),
          jenis_obat: $("#jenis_obat").val(),
          harga: $('input[name="harga"]').val(),
          stok: $('input[name="stok"]').val(),
        };
        id = prepareData.kd_obat;
        break;

      case "pembelian":
        prepareData = {
          kd_beli: $("#kd_beli").val(),
          kd_obat: $("#selectOption").val(),
          tgl_beli: $('input[name="tgl_beli"]').val(),
          jumlah: $('input[name="jumlah"]').val(),
        };

        id = prepareData.kd_beli;
        break;

      case "biaya":
        prepareData = {
          id: $("#id").val(),
          nama: $('input[name="nama"]').val(),
          biaya_bln: $('input[name="biaya_bln"]').val(),
          jumlah: $('input[name="jumlah"]').val(),
          total: $('input[name="total"]').val(),
        };

        id = prepareData.id;
        break;

      case "kebutuhan-pertahun":
        prepareData = {
          id: $("#id").val(),
          kd_obat:
            kd_obatOption !== null
              ? kd_obatOption
              : $("#selectEdit").data("kode"),
          k_tahun: $('input[name="k_tahun"]').val(),
          jumlah: $('input[name="jumlah"]').val(),
        };

        id = prepareData.id;
        break;

      default:
        console.log("No type");
    }

    const param = {
      id: id,
      data: prepareData,
    };

    updateData(param, pagePath);
  });

  // Delete user
  $("#displaying").on("click", ".delete", function () {
    let prepareData = {};

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        switch (pagePath) {
          case "data-user":
            let kd_admin = $(this).attr("data-id");
            prepareData = {
              id: kd_admin,
              field: kd_admin,
            };
            break;

          case "data-obat":
            let kd_obat = $(this).attr("data-id");
            prepareData = {
              id: kd_obat,
              field: kd_obat,
            };
            break;

          case "pembelian":
            let kd_beli = $(this).attr("data-id");
            prepareData = {
              id: kd_beli,
              field: kd_beli,
            };
            break;

          case "biaya":
            let id_biaya = $(this).attr("data-id");
            prepareData = {
              id: id_biaya,
              field: id_biaya,
            };
            break;

          case "kebutuhan-pertahun":
            let id_ktahun = $(this).attr("data-id");
            prepareData = {
              id: id_ktahun,
              field: id_ktahun,
            };
            break;
        }

        loading.classList.remove("hidden");
        loading.classList.add("block");

        console.log(prepareData);

        deleteData(prepareData, pagePath);
      }
    });
  });

  // Close modal & clear data input value
  $("#addModal").on("click", ".close-modal", function (e) {
    e.preventDefault();
    $('input[name="kd_admin"]').val("");
    $('input[name="nm_lengkap"]').val("");
    $('textarea[name="alamat"]').val("");
    $('input[name="notlp"]').val("");
    $('input[name="username"]').val("");
    kd_obatOption = null;
    $("#selectOption").val(null).trigger("change");
    alertError.hide();
    messageError.html("");
    loadingBtn.addClass("hidden");
    textBtn.removeClass("hidden");
  });

  // option select lists obat from select2
  // $('#selectOption').select2({
  // 	placeholder: 'Pilih Obat',
  //     allowClear: true,
  //     minimumInputLength: 3,
  //     ajax: {
  //         url: $('#selectOption').data('action'),
  //         dataType: 'json',
  //         delay: 100,
  //         processResults: function(data) {
  //         	console.log(data)
  //         	return {
  //         		results: data
  //         	};
  //         },
  //         cache: true
  //     }
  // }).on('select2:select', function(e) {
  //     let selectedValue = e.params.data.id; // Mendapatkan nilai (value) opsi terpilih
  //     kd_obatOption = selectedValue;
  // });

  // Fungsi untuk memuat data dan menginisialisasi Select2

  // Memanggil fungsi di atas saat dokumen siap

  loadAndInitializeSelect2();

  if (pagePath === "kebutuhan-pertahun") {
    loadInitializeSelect2Edit();
  }

  $("#selectOption").on("select2:select", function (e) {
    let selectedValue = e.params.data.id;
    kd_obatOption = selectedValue;
    if (pagePath === "pengajuan-obat") {
      const dataKtahun = {
        kd_obat: kd_obatOption,
      };
      getData("input-formula", dataKtahun);
    }
  });
});

if (pagePath !== "pengajuan-obat") {
  getAllData(pagePath, 1);
}

if (pagePath === "pembelian") {
  logPembelian();
}
