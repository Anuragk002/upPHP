// input quantity ---->only numbers are allowed(decimal and leading zero not allowed)
// $("#p_qty").on("input", function() {
//     if (/^0/.test(this.value)) {
//       this.value = this.value.replace(/^0+/, "")
//     }
//     this.value=(Math.trunc(this.value)||1);
//   })

  function qtyPlus(){
    var in_value= document.getElementById('p_qty');
    in_value.value=1 + Math.trunc(in_value.value);
    document.getElementById("qty_text").innerHTML = in_value.value;
  }

  function qtyMinus(){
    var in_value= document.getElementById('p_qty');
    if (in_value.value>=2){
    in_value.value=Math.trunc(in_value.value) - 1;
    document.getElementById("qty_text").innerHTML = in_value.value;
    }
  }
