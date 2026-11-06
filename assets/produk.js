/* ============================================================
   kasirsmk/assets/produk.js
   Function jQuery untuk form produk KasirSMK.

   Prinsip:
   - PHP tetap memvalidasi dan menyimpan data.
   - JavaScript hanya membantu pengguna melihat hasil lebih cepat.
   - Bootstrap dipakai untuk tampilan dan class validasi.
   ============================================================ */

function aktifkanHurufBesar() {
  $("#kode_produk").on("input", function () {
    this.value = this.value.toUpperCase();
  });
}

function perbaruiNama() {
  var $nama = $("#nama_produk");
  var $hitung = $("#hitung-nama");
  var $pratinjau = $("#pratinjau-nama");

  if ($nama.length === 0) {
    return;
  }

  function tampilkan() {
    var nama = $nama.val() || "";
    var jumlah = nama.length;

    $pratinjau.text(nama === "" ? "Belum ada nama produk." : nama);
    $hitung
      .text(jumlah + " / 50 karakter")
      .toggleClass("text-danger", jumlah > 50);
  }

  $nama.on("input", tampilkan);
  tampilkan();
}

function perbaruiLaba() {
  var $beli = $("#harga_beli");
  var $jual = $("#harga_jual");
  var $kotak = $("#ringkasan-laba");

  if ($kotak.length === 0) {
    return;
  }

  var rupiah = new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    maximumFractionDigits: 0
  });

  function aturKotak(kelas, teks) {
    $kotak
      .removeClass("alert-secondary alert-success alert-danger")
      .addClass(kelas)
      .text(teks);
  }

  function hitung() {
    var beli = parseFloat($beli.val());
    var jual = parseFloat($jual.val());

    if (isNaN(beli) || isNaN(jual)) {
      aturKotak(
        "alert-secondary",
        "Isi harga beli dan harga jual untuk melihat laba."
      );
      return;
    }

    var laba = jual - beli;
    var margin = beli > 0 ? (laba / beli) * 100 : null;
    var teksMargin = margin === null
      ? "Margin: -"
      : "Margin: " + margin.toFixed(1).replace(".", ",") + "%";

    if (laba < 0) {
      aturKotak(
        "alert-danger",
        "Rugi: " + rupiah.format(Math.abs(laba)) + " | " + teksMargin
      );
      return;
    }

    aturKotak(
      "alert-success",
      "Laba: " + rupiah.format(laba) + " | " + teksMargin
    );
  }

  $beli.add($jual).on("input", hitung);
  hitung();
}

function pasangValidasiBlur() {
  var $input = $("#form-produk input[required]");

  if ($input.length === 0) {
    return;
  }

  $input.on("blur", function () {
    var nilai = $.trim($(this).val());
    var valid = nilai !== "";

    if (this.type === "number") {
      valid = valid && !isNaN(parseFloat(nilai)) && parseFloat(nilai) >= 0;
    }

    $(this)
      .toggleClass("is-invalid", !valid)
      .toggleClass("is-valid", valid);
  });

  $input.on("input", function () {
    $(this).removeClass("is-invalid");
  });
}

function pasangKonfirmasiHapus() {
  $("form[data-confirm]").on("submit", function (event) {
    var pesan = $(this).data("confirm");

    if (!window.confirm(pesan)) {
      event.preventDefault();
    }
  });
}

function pasangAntiKlikGanda() {
  $("#form-produk, #form-hapus").on("submit", function (event) {
    if (event.isDefaultPrevented()) {
      return;
    }

    $(this)
      .find("button[type='submit']")
      .prop("disabled", true)
      .text("Memproses...");
  });
}

$(function () {
  aktifkanHurufBesar();
  perbaruiNama();
  perbaruiLaba();
  pasangValidasiBlur();
  pasangKonfirmasiHapus();
  pasangAntiKlikGanda();
});
