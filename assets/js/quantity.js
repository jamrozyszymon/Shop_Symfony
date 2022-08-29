    const plus = document.querySelector("#add_to_cart_form_plus"),
    minus = document.querySelector("#add_to_cart_form_minus"),
    quantity = document.querySelector("#add_to_cart_form_quantity");

    let a = 1;
    plus.addEventListener("click", ()=>{
      a++;
      quantity.value=a;
    });

    minus.addEventListener("click", ()=>{
      if(a > 1){
        a--;
        quantity.value=a;
      }
    });
