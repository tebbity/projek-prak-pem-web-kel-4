document.addEventListener("DOMContentLoaded", function() {
    //1. preview foto dan validasi ukuran file
    const inputFoto = document.querySelector('input[type="file"][name="foto]');
    if(inputFoto){
        const previewImg = document.createElement("img");
        previewImg.id = "preview-foto";
        previewImg.alt = "Preview Foto Lapangan";
        inputFoto.parentNode.appendChild(previewImg);

        inputFoto.addEventListener("change", function(){
            const file = this.file[0];
            if(!file){
                previewImg.style.display = "none";
                return;
            }

            //maks 2MB
            const maxSize = 2 * 1024 * 1024;
            if(file.size > maxSize){
                alert("Ukuran foto terlalu besar! Maksimal 2 MB.");
                this.value = "";
                previewImg.style.display = "none";
                return;
            }

            //Preview gambar
            const reader = new FileReader();
            reader.onload = function(e){
                previewImg.src = e.target.result;
                previewImg.style.display = "block";
            };
            reader.readAsDataURL(file);
        });
    }
    
    //2. Validasi Harga
    const inputHarga = document.querySelector('input[name="harga_per_jam"]');
    if(inputHarga){
        inputHarga.addEventListener("input", function(){
            if(this.value < 0) this.value = 0;
        });
    }

    //3. Kalkulator total sewa
    const selectLapangan = document.querySelector('select[name="id_lapangan"]');
    const inputDurasi = document.querySelector('input[name="durasi"], input[name="lama_sewa"]');
    const labelTotal = document.getElementById("estimasi-total");

    function hitungTotalSewa(){
        if (!selectLapangan || !inputDurasi || !labelTotal) return;
        const selectedOption = selectLapangan.options[selectLapangan.selectedIndex];
        const harga = parseInt(selectedOption.getAttribute("data-harga")) || 0;
        const durasi = parseInt(inputDurasi.value) || 0;
        const total = harga * durasi;

        labelTotal.textContent = "Rp " + total.toLocaleString("id-ID");
    }

    if (selectLapangan && inputDurasi) {
        selectLapangan.addEventListener("change", hitungTotalSewa);
        inputDurasi.addEventListener("input", hitungTotalSewa);
    }
});
