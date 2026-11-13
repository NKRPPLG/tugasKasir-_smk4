/* ============================================================
   kasirsmk/assets/transaksi.js
   Interaksi form transaksi: tambah/hapus baris, isi harga,
   hitung subtotal dan total nota.
   ============================================================ */

(function ($) {
  var rupiah = new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    maximumFractionDigits: 0
  });

  function angka(nilai) {
    var hasil = parseFloat(nilai);
    return isNaN(hasil) ? 0 : hasil;
  }

  function hitungTotal() {
    var total = 0;

    $("#tabel-item .baris-item").each(function () {
      var jumlah = angka($(this).find(".input-jumlah").val());
      var harga = angka($(this).find(".input-harga").val());
      total += jumlah * harga;
    });

    $("#total-nota").text(rupiah.format(total));
  }

  function pasangBaris($baris) {
    var $pilih = $baris.find(".pilih-produk");
    var $jumlah = $baris.find(".input-jumlah");
    var $harga = $baris.find(".input-harga");
    var $subtotal = $baris.find("[data-subtotal]");
    var $info = $baris.find(".info-produk");

    function perbaruiSubtotal() {
      var nilai = angka($jumlah.val()) * angka($harga.val());
      $subtotal.text(rupiah.format(nilai));
      hitungTotal();
    }

    $pilih.on("change", function () {
      var $opsi = $(this).find("option:selected");
      var nama = $opsi.data("nama") || "";
      var harga = $opsi.data("harga");
      var stok = $opsi.data("stok");

      if ($(this).val() !== "") {
        $harga.val(harga);
        $info.text(nama + " | stok tersedia: " + stok);
      } else {
        $harga.val("");
        $info.text("Pilih produk untuk melihat stok.");
      }

      perbaruiSubtotal();
    });

    $jumlah.add($harga).on("input", perbaruiSubtotal);

    $baris.find(".btn-hapus-baris").on("click", function () {
      var $semua = $("#tabel-item .baris-item");

      if ($semua.length <= 1) {
        $pilih.val("");
        $jumlah.val("1");
        $harga.val("");
        $info.text("Pilih produk untuk melihat stok.");
        perbaruiSubtotal();
        return;
      }

      $baris.remove();
      hitungTotal();
    });

    perbaruiSubtotal();
  }

  $(function () {
    $("#tabel-item .baris-item").each(function () {
      pasangBaris($(this));
    });

    $("#btn-tambah-baris").on("click", function () {
      var template = document.getElementById("template-baris");

      if (!template) {
        return;
      }

      var isi = template.content.cloneNode(true);
      document.querySelector("#tabel-item tbody").appendChild(isi);

      var $barisBaru = $("#tabel-item .baris-item").last();
      pasangBaris($barisBaru);
      $barisBaru.find(".pilih-produk").trigger("focus");
      hitungTotal();
    });

    hitungTotal();
  });
})(jQuery);
