    //increment/decrement quantity by button 
    
    //JS
    
    // const plus = document.querySelector("#add_to_cart_form_plus"),
    // minus = document.querySelector("#add_to_cart_form_minus"),
    // quantity = document.querySelector("#add_to_cart_form_quantity");

    // let a = 1;
    // plus.addEventListener("click", ()=>{
    //   a++;
    //   quantity.value=a;
    // });

    // minus.addEventListener("click", ()=>{
    //   if(a > 1){
    //     a--;
    //     quantity.value=a;
    //   }
    // });


//JQuery

var quantity=$("#add_to_cart_form_quantity");
console.log(quantity);

var n=1;

$("#add_to_cart_form_plus").on('click', function(){
  $(quantity).val(++n);
})

$("#add_to_cart_form_minus").on('click', function(){
  if(n>1) {
    $(quantity).val(--n);
  }
})