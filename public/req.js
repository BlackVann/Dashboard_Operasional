  let index = 1;
  function reqProduk() {
    const container = document.getElementById('req-list');
    const html = `
      <div class="req-item">
      <div class="row">
      <div class="col">
      <label>Produk:</label>
      <input type="text" name="request[${index}][nama]" list="daftar-produk" class="form-control" required >
      </div class="col">
      <div class="col">
                    <label>Jumlah:</label>
              <input type="number" name="request[${index}][jumlah]" class="form-control" required>
      </div>
      </div>
            </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    index++;
  }

