  let index = 1;

  function tambahProduk() {
    const container = document.getElementById('form-list');
    const html = `
                 <div class="form-item">
              <div class="row" id="row${index}">
                <div class="col-11">
                  <div class="row">
                    <div class="col-8">
                      <label>Produk:</label>
                  <input type="text" list="daftar-produk" name="produk[${index}][nama]" required class="form-control">
                    </div>
                    <div class="col-4 ">
                      <label>Jumlah:</label>
                      <input type="number" name="produk[${index}][jumlah]" required class="form-control">
                    </div>
                    <div class="col-12">
                      <label>Customer:</label>
              <input type="text" name="produk[${index}][customer]" required class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-1">
                  <div class="row">
                    <div class="col-2 col-sm-1 "><button type="button" class="btn-close" aria-label="Close" onclick="hapus(${index})"></button></div>
                  </div>
                </div>
               
               
              </div>
              

              <input type="hidden" name="produk[${index}][id]" value="${index+1}">
              
            </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    index++;
    
  }
  function hapus(id){
    const element = document.getElementById("row" + id);
element.remove();
  }

