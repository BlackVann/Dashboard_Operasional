  let index = 1;

  function tambahProduk() {
    const container = document.getElementById('form-list');
    const html = `
                 <div class="form-item">
              <div class="row" id="row${index}">
                
                  
                    <div class="col-4">
                      <label>Produk:</label>
                  <input type="text"  name="produk[${index}][nama]" required class="form-control">
                    </div>
                    <div class="col-4 ">
                      <label>Jumlah:</label>
                      <input type="number" name="produk[${index}][jumlah]" required class="form-control">
                    </div>
                
                  
                    <div class="col-4 "><button type="button" class="btn-close" aria-label="Close" onclick="hapus(${index})"></button></div>
                  </div>
                </div>        
            </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    index++;
    
  }
  function tambahProduk1() {
    const container = document.getElementById('form-list');
    const html = `
                 <div class="form-item">
              <div class="row" id="row${index}">
                
                  
                    <div class="col-4">
                      <label>Produk:</label>
                  <input type="text"  name="produk[${index}][nama]" required class="form-control">
                    </div>
                    <div class="col-3 ">
                      <label>Jumlah:</label>
                      <input type="number" name="produk[${index}][jumlah]" required class="form-control">
                    </div>
                 <div class="col-3">
                    <label>Harga:</label>
                <input type="number" name="produk[${index}][harga]" required class="form-control"> 
                  </div>
                  
                    <div class="col-2 "><button type="button" class="btn-close" aria-label="Close" onclick="hapus(${index})"></button></div>
                  </div>
                </div>    
              
            </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    index++;
    
  }
  function tambahStokGudang() {
    const container = document.getElementById('form-list');
    const html = `
                 <div class="form-item">
              <div class="row" id="row${index}">
                
                  
                  <div class="col-6">
                    <label>Produk:</label>
                <input type="text" list="daftar-produk" name="produk[${index}][nama]" required class="form-control" autocomplete="off">  
              </div>                  
              <div class="col-5">
                    <label>Jumlah:</label>
                <input type="text" name="produk[${index}][jumlah]" required class="form-control">  
              </div>
               <div class="col-1"><button style="margin-top:2rem " type="button" class="btn-close" aria-label="Close" onclick="hapus(${index})"></button></div>
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

