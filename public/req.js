  let index = 1;
  var id='';
  function reqProduk() {
    const container = document.getElementById('req-list');
    const html = `
      <div class="req-item">
      <div class="row">
      <div class="col-6">
      <label>Produk:</label>
      <input type="text" name="request[${index}][nama]" list="daftar-produk" class="form-control" required >
      </div>
      <div class="col-4">
                    <label>Jumlah:</label>
              <input type="number" name="request[${index}][jumlah]" class="form-control" required>
      </div>
      <input type="hidden" name="request[${index}][location]" value="Toko A"
      >
       <div class="col-2"><button type="button" class="btn-close" aria-label="Close" onclick="hapus(${index})"></button></div>
      </div>
            </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    index++;
  }

  function hapus(id){
    const element = document.getElementById("row" + id);
element.remove();
  }

