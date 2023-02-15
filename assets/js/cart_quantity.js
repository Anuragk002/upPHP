function cartPlus(id){
    var in_value= document.getElementById('cart_qty'+id);
    in_value.value=1 + Math.trunc(in_value.value);
    document.getElementById("cart_text"+id).innerHTML = in_value.value;
  }

  function cartMinus(id){
    var in_value= document.getElementById('cart_qty'+id);
    if (in_value.value>=2){
    in_value.value=Math.trunc(in_value.value) - 1;
    document.getElementById("cart_text"+id).innerHTML = in_value.value;
    }
  }
