// selecting package------->
var active = "";
function pkgSelect(id, price) {
  event.preventDefault();
  var btn = document.getElementById(id);
  var state = btn.dataset.state;
  var cart_btn=document.getElementById('btn_add_to_cart');
  cart_btn.classList.remove('disabled');
  if (state == 0 && active != "") {
    document.getElementById("pkg-amount").innerHTML = "$" + price;
    document.getElementById("p_pkg_id").value = id;
    btn.setAttribute("data-state", "1");
    btn.classList.remove("pkg_btn");
    btn.classList.add("pkg_btn_active");

    var prev = document.getElementById(active);
    prev.setAttribute("data-state", "0");
    prev.classList.remove("pkg_btn_active");
    prev.classList.add("pkg_btn");
  }
  if (state == 0 && active == "") {
    document.getElementById("pkg-amount").innerHTML = "$" + price;
    document.getElementById("p_pkg_id").value = id;
    btn.setAttribute("data-state", "1");
    btn.classList.remove("pkg_btn");
    btn.classList.add("pkg_btn_active");
  }
  active = id;
}
