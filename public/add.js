  let index = 1;
  function tambahProduk() {
    const container = document.getElementById('form-list');
    const html = `
      <div class="form-item">
      <div class="row">
      <div class='col'>
      <label>Produk:</label>
              <input type="text" name="produk[${index}][nama]" class="form-control" required>
        </div>
        <div class='col'> 
              <label>Jumlah:</label>
              <input type="number" name="produk[${index}][jumlah]" class="form-control" required>
             </div> 
         <div class='col'>
              <label>Customer:</label>
          <input type="text" name="produk[${index}][customer]" class="form-control" required>
      </div>
              
       <input type="hidden" name="produk[${index}][id]" value="${index+1}">

            </div>
            </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    index++;
  }

