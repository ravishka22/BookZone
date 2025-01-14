function ChangeView() {
  var SignUpBox = document.getElementById("SignUpBox");
  var SignInBox = document.getElementById("SignInBox");

  SignUpBox.classList.toggle("d-none");
  SignInBox.classList.toggle("d-none");
}

function signUp() {
  var fn = document.getElementById("fname");
  var ln = document.getElementById("lname");
  var e = document.getElementById("email");
  var m = document.getElementById("mobile");
  var pw = document.getElementById("password");
  var g = document.getElementById("gender");

  var f = new FormData();
  f.append("fname", fn.value);
  f.append("lname", ln.value);
  f.append("email", e.value);
  f.append("password", pw.value);
  f.append("mobile", m.value);
  f.append("gender", g.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t == "Register success") {
        Swal.fire({
          icon: "success",
          title: "Registration Successful",
          showConfirmButton: true,
          timer: 1500,
        });
        setInterval(() => {
          window.location.reload();
        }, 1500);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: false,
          timer: 1500,
        });
        // document.getElementById("msg").innerHTML = t;
        // document.getElementById("msgdiv").className = "d-block";
      }
    }
  };

  r.open("POST", "signUpProcess.php", true);
  r.send(f);
}

function signin() {
  var email = document.getElementById("email2");
  var password = document.getElementById("password2");
  var rememberme = document.getElementById("rememberme");

  var f = new FormData();
  f.append("e", email.value);
  f.append("p", password.value);
  f.append("r", rememberme.checked);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success") {
        Swal.fire({
          icon: "success",
          title: "Your Loging Successful",
          showConfirmButton: true,
          timer: 1000,
        });
        setInterval(() => {
          window.location = "index.php";
        }, 1000);
      } else if (t == "admin") {
        Swal.fire({
          icon: "success",
          title: "Admin Loging Successful",
          showConfirmButton: true,
          timer: 1000,
        });
        setInterval(() => {
          window.location = "admin-dashboard.php";
        }, 1000);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: false,
          timer: 1000,
        });
      }
    }
  };

  r.open("POST", "signinProcess.php", true);
  r.send(f);
}

function showPassword() {
  var x = document.getElementById("password");
  if (x.type == "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function showPassword2() {
  var x1 = document.getElementById("password1");
  var x2 = document.getElementById("password2");
  if (x1.type == "password") {
    x1.type = "text";
  } else {
    x1.type = "password";
  }
  if (x2.type == "password") {
    x2.type = "text";
  } else {
    x2.type = "password";
  }
}

var bm;
function forgotPassword() {
  var email = document.getElementById("email3");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Code sent successfully") {
        var m = document.getElementById("forgotPasswordModal");
        bm = new bootstrap.Modal(m);
        bm.show();
        document.getElementById("msg2").innerHTML = t;
        document.getElementById("msg2").className = "alert alert-success";
        document.getElementById("msgdiv2").className = "d-block";
      } else {
        document.getElementById("msg2").innerHTML = t;
        document.getElementById("msgdiv2").className = "d-block";
      }
    }
  };

  r.open("GET", "forgotPasswordProcess.php?e=" + email.value, true);
  r.send();
}

function resetPassword() {
  var email = document.getElementById("email3");
  var np = document.getElementById("np");
  var rnp = document.getElementById("rnp");
  var vc = document.getElementById("vc");

  var f = new FormData();
  f.append("e", email.value);
  f.append("np", np.value);
  f.append("rnp", rnp.value);
  f.append("vc", vc.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t == "success") {
        bm.hide();
        alert("Your password has been updated.");
        document.getElementById("msg2").innerHTML = t;
        document.getElementById("msg2").className = "alert alert-danger";
        document.getElementById("msgdiv2").className = "d-block";
        window.location.reload();
      } else {
        document.getElementById("msg2").innerHTML = t;
        document.getElementById("msgdiv2").className = "d-block";
      }
    }
  };

  r.open("POST", "resetPasswordProcess.php", true);
  r.send(f);
}

function signout() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t == "success") {
        window.location = "login.php";
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "signOutProcess.php", true);
  r.send();
}

function showOverview() {
  document.getElementById("overviewbtn").className =
    "btn btn-light btn-lg w-100 p-3 my-1 active";
  document.getElementById("ordersbtn").className =
    "btn btn-light btn-lg w-100 p-3 my-1";
  document.getElementById("accsettingsbtn").className =
    "btn btn-light btn-lg w-100 p-3 my-1";

  document.getElementById("overviewbody").className = "d-block";
  document.getElementById("ordersbody").className = "d-none";
  document.getElementById("accsettingsbody").className = "d-none";

  document.documentElement.scrollTop = 0;
}

function showOrders() {
  document.getElementById("overviewbtn").className =
    "btn btn-light btn-lg w-100 p-3 my-1";
  document.getElementById("ordersbtn").className =
    "btn btn-light btn-lg w-100 p-3 my-1 active";
  document.getElementById("accsettingsbtn").className =
    "btn btn-light btn-lg w-100 p-3 my-1";

  document.getElementById("overviewbody").className = "d-none";
  document.getElementById("ordersbody").className = "d-block";
  document.getElementById("accsettingsbody").className = "d-none";

  document.documentElement.scrollTop = 0;
}

function showAccSettings() {
  document.getElementById("overviewbtn").className =
    "btn btn-light btn-lg w-100 p-3 my-1";
  document.getElementById("ordersbtn").className =
    "btn btn-light btn-lg w-100 p-3 my-1";
  document.getElementById("accsettingsbtn").className =
    "btn btn-light btn-lg w-100 p-3 my-1 active";

  document.getElementById("overviewbody").className = "d-none";
  document.getElementById("ordersbody").className = "d-none";
  document.getElementById("accsettingsbody").className = "d-block";

  document.documentElement.scrollTop = 0;
}

function changeProfileImage() {
  var propic = document.getElementById("propicuploader");
  propic.onchange = function () {
    var file = this.files[0];
    var url = window.URL.createObjectURL(file);
    document.getElementById("propic").src = url;
  };
}

function changeBookImage() {
  var propic = document.getElementById("bookImgUploader");
  propic.onchange = function () {
    var file = this.files[0];
    var url = window.URL.createObjectURL(file);
    document.getElementById("bookImg").src = url;
  };
}

function resetImageSelection() {
  var file = document.getElementById("propicuploader");
  file.value = "";
  var oldpropic = document.getElementById("propic3").getAttribute("src");
  document.getElementById("propic").src = oldpropic;
}
function resetImageSelection2() {
  var file = document.getElementById("propicuploader");
  file.value = "";
  document.getElementById("propic").src = "resourses/default_propic.jpg";
}

function updateAccountDetails() {
  var profile_img = document.getElementById("propicuploader");
  var first_name = document.getElementById("asfname");
  var last_name = document.getElementById("aslname");
  var email_address = document.getElementById("asemail");
  var phone_no = document.getElementById("asphone");
  var birth_day = document.getElementById("asbday");
  var gender = document.getElementById("asgender");

  var f = new FormData();
  f.append("img", profile_img.files[0]);
  f.append("fn", first_name.value);
  f.append("ln", last_name.value);
  f.append("ea", email_address.value);
  f.append("mn", phone_no.value);
  f.append("bd", birth_day.value);
  f.append("g", gender.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;

      if (t == "success") {
        Swal.fire({
          icon: "success",
          title: "Your Details has been saved",
          showConfirmButton: false,
          timer: 1500,
        });
        setInterval(() => {
          window.location.reload();
        }, 1500);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
        });
      }
    }
  };
  r.open("POST", "updateAccountDetailsProcess.php", true);
  r.send(f);
}

function loadDistricts() {
  var selector = document.getElementById("province");
  var selected_id = selector.value;

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      document.getElementById("district").innerHTML = t;
    }
  };
  r.open("GET", "loadDistrictsProcess.php?p=" + selected_id, true);
  r.send();
}

function loadBillingDistricts() {
  var selector = document.getElementById("baprovince");
  var selected_id = selector.value;

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      document.getElementById("badistrict").innerHTML = t;
    }
  };
  r.open("GET", "loadDistrictsProcess.php?p=" + selected_id, true);
  r.send();
}

function loadShippingDistricts() {
  var selector = document.getElementById("shaprovince");
  var selected_id = selector.value;

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      document.getElementById("shadistrict").innerHTML = t;
    }
  };
  r.open("GET", "loadDistrictsProcess.php?p=" + selected_id, true);
  r.send();
}

function saveAddress() {
  var address_line1 = document.getElementById("aline1");
  var address_line2 = document.getElementById("aline2");
  var address_p = document.getElementById("province");
  var address_d = document.getElementById("district");
  var address_c = document.getElementById("city");
  var address_pc = document.getElementById("pcode");

  var f = new FormData();
  f.append("al1", address_line1.value);
  f.append("al2", address_line2.value);
  f.append("ap", address_p.value);
  f.append("ad", address_d.value);
  f.append("ac", address_c.value);
  f.append("apc", address_pc.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        Swal.fire({
          icon: "success",
          title: "Your Address has been saved",
          showConfirmButton: false,
          timer: 1500,
        });
        setInterval(() => {
          window.location.reload();
        }, 1500);
      } else {
        Swal.fire({
          icon: "error",
          title: "Opps...",
          text: t,
          showConfirmButton: false,
          timer: 1500,
        });
      }
    }
  };
  r.open("POST", "saveAddressProcess.php", true);
  r.send(f);
}

function updatePassword() {
  var pass1 = document.getElementById("password1");
  var pass2 = document.getElementById("password2");
  var f = new FormData();
  f.append("p1", pass1.value);
  f.append("p2", pass2.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;

      if (t == "success") {
        Swal.fire({
          icon: "success",
          title: "Your Details has been saved",
          showConfirmButton: false,
          timer: 1500,
        });
        setInterval(() => {
          signout();
        }, 1500);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
        });
      }
    }
  };
  r.open("POST", "updatePasswordProcess.php", true);
  r.send(f);
}

function deactivateAccount() {
  var checkbox = document.getElementById("deleteAccount");
  if (checkbox.checked) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
      if (r.status == 200 && r.readyState == 4) {
        var t = r.responseText;
        if (t == "success") {
          Swal.fire({
            icon: "success",
            title: "Your Account is Deactivated",
            showConfirmButton: true,
            timer: 1500,
          });
          setInterval(() => {
            signout();
          }, 1500);
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: t,
            showConfirmButton: false,
            timer: 1500,
          });
        }
      }
    };
    r.open("GET", "deactivateAccountProcess.php", true);
    r.send();
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Please confirm your deactivation",
      showConfirmButton: false,
      timer: 1500,
    });
  }
}

function viewDiscriptionBox(tabHeading) {
  tabHeading.classList.add("active");
  document.getElementById("bookReview").classList.remove("active");
  document.getElementById("bookMoreDetails").classList.remove("active");

  document.getElementById("discriptionBox").classList = "d-block";
  document.getElementById("reviewBox").classList = "d-none";
  document.getElementById("moreDetailsBox").classList = "d-none";
}

function viewReviewBox(tabHeading) {
  tabHeading.classList.add("active");
  document.getElementById("bookDiscription").classList.remove("active");
  document.getElementById("bookMoreDetails").classList.remove("active");

  document.getElementById("discriptionBox").classList = "d-none";
  document.getElementById("reviewBox").classList = "d-block";
  document.getElementById("moreDetailsBox").classList = "d-none";
}

function viewMoreDetailsBox(tabHeading) {
  tabHeading.classList.add("active");
  document.getElementById("bookDiscription").classList.remove("active");
  document.getElementById("bookReview").classList.remove("active");

  document.getElementById("discriptionBox").classList = "d-none";
  document.getElementById("reviewBox").classList = "d-none";
  document.getElementById("moreDetailsBox").classList = "d-block";
}

function check_value(qty, input) {
  var x = document.getElementById("snackbar");

  if (input.value < 1) {
    x.innerHTML = "You must add 1 or more";
    x.className = "show bg-danger";
    setTimeout(function () {
      x.className = x.className.replace("show", "");
    }, 3000);
    input.value = 1;
  } else if (input.value > qty) {
    x.innerHTML = "You can't add more than " + qty;
    x.className = "show bg-danger";
    setTimeout(function () {
      x.className = x.className.replace("show", "");
    }, 3000);
    input.value = qty;
  }
}

function addToCart(id, qty) {
  var pid = id;
  if (qty == "") {
    qty.value = 1;
  }
  var x = document.getElementById("snackbar");
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "This Book Already exists In the Cart") {
        Swal.fire({
          icon: "warning",
          title: t,
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonText: "View Cart",
          timer: 5000,
        }).then((result) => {
          if (result.isConfirmed) {
            window.location = "cart.php";
          }
        });
      } else if (t == "Book Added") {
        // deleteFromWishlist(pid);
        Swal.fire({
          icon: "success",
          title: "Book Added To Cart Successfully",
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonText: "View Cart",
          timer: 5000,
        }).then((result) => {
          if (result.isConfirmed) {
            window.location = "cart.php";
          }
        });
      } else if (t == "Please Login") {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: true,
          // timer: 1500,
        });
        setTimeout(function () {
          window.location = "login.php";
        }, 1500);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: true,
          // timer: 1500,
        });
      }
      // myFunction(t);
    }
  };

  r.open("GET", "addToCartProcess.php?id=" + pid + "&qty=" + qty.value, true);
  r.send();
}

function updateCartQty(bid, input) {
  var x = document.getElementById("snackbar");
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "Cart Updated") {
        // window.location.reload();
        x.innerHTML = "Cart Updated Successfully";
        x.className = "show bg-success";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
          window.location.reload();
        }, 1000);
      } else {
        x.innerHTML = t;
        x.className = "show bg-danger";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
        }, 3000);
      }
    }
  };

  r.open(
    "GET",
    "updateCartQtyProcess.php?id=" + bid + "&qty=" + input.value,
    true
  );
  r.send();
}

function deleteFromCart(bid) {
  var x = document.getElementById("snackbar");
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        x.innerHTML = "Book removed from cart";
        x.className = "show bg-success";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
          window.location.reload();
        }, 1000);
      } else {
        x.innerHTML = t;
        x.className = "show bg-danger";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
        }, 3000);
      }
    }
  };

  r.open("GET", "deleteFromCartProcess.php?id=" + bid, true);
  r.send();
}

function addToWishlist(id, btnID) {
  var pid = id;

  var x = document.getElementById("snackbar");
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "Already exists In the Wishlist") {
        Swal.fire({
          icon: "warning",
          title: t,
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonText: "View Wishlist",
          timer: 5000,
        }).then((result) => {
          if (result.isConfirmed) {
            window.location = "wishlist .php";
          }
        });
      } else if (t == "Book Added") {
        Swal.fire({
          icon: "success",
          title: "Book Added To Wishlist Successfully",
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonText: "View Wishlist",
          timer: 5000,
        }).then((result) => {
          if (result.isConfirmed) {
            window.location = "wishlist.php";
          }
        });
      } else if (t == "Please Login") {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: true,
          // timer: 1500,
        });
        setTimeout(function () {
          window.location = "login.php";
        }, 1500);
      } else {
        btnID.innerHTML = "<i class='bi bi-heart'></i>";
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: true,
          // timer: 1500,
        });
      }
      // myFunction(t);
    }
  };

  r.open("GET", "addToWishlistProcess.php?id=" + pid, true);
  r.send();
}

function deleteFromWishlist(bid) {
  var x = document.getElementById("snackbar");
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        x.innerHTML = "Book removed from wishlist";
        x.className = "show bg-success";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
          window.location.reload();
        }, 1000);
      } else {
        x.innerHTML = t;
        x.className = "show bg-danger";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
        }, 3000);
      }
    }
  };

  r.open("GET", "deleteFromWishlistProcess.php?id=" + bid, true);
  r.send();
}

function activeShippingAddress(checkbox) {
  var adbox = document.getElementById("saddressBox");
  if (checkbox.checked) {
    // alert("OK");
    adbox.classList.remove("d-none");
  } else {
    adbox.classList.add("d-none");
  }
}

function checkout(id, price, qty, weight) {
  var bookQty;
  var totalWeight;
  var subTotal;
  var bookID;

  bookQty = qty.value;
  totalWeight = weight * bookQty;
  subTotal = price * bookQty;
  bookID = id;

  var f = new FormData();
  f.append("bid", bookID);
  f.append("st", subTotal);
  f.append("tw", totalWeight);
  f.append("bq", bookQty);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        Swal.fire({
          icon: "success",
          title: "You are ready to checkout",
          showConfirmButton: false,
          timer: 1000,
        });
        setInterval(() => {
          window.location = "checkout.php";
        }, 1000);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: true,
          // timer: 1500,
        });
      }
    }
  };

  r.open("POST", "addCheckoutProcess.php", true);
  r.send(f);
}

function payNow(orderId) {
  var cbox;
  var shippingCheck = document.getElementById("sAddressCheck");
  if (shippingCheck.checked) {
    cbox = 1;
  } else {
    cbox = 0;
  }

  var order_note = document.getElementById("orderNote");

  var b_fname = document.getElementById("bafname");
  var b_lname = document.getElementById("balname");
  var b_email = document.getElementById("baemail");
  var b_phone = document.getElementById("baphone");
  var b_line1 = document.getElementById("baline1");
  var b_line2 = document.getElementById("baline2");
  var b_province = document.getElementById("baprovince");
  var b_district = document.getElementById("badistrict");
  var b_city = document.getElementById("bacity");
  var b_pcode = document.getElementById("bapcode");

  var s_fname = document.getElementById("shafname");
  var s_lname = document.getElementById("shalname");
  var s_line1 = document.getElementById("shaline1");
  var s_line2 = document.getElementById("shaline2");
  var s_province = document.getElementById("shaprovince");
  var s_district = document.getElementById("shadistrict");
  var s_city = document.getElementById("shacity");
  var s_pcode = document.getElementById("shapcode");

  var f = new FormData();

  f.append("onote", order_note.value);

  f.append("bfn", b_fname.value);
  f.append("bln", b_lname.value);
  f.append("be", b_email.value);
  f.append("bp", b_phone.value);
  f.append("bl1", b_line1.value);
  f.append("bl2", b_line2.value);
  f.append("bpro", b_province.value);
  f.append("bdis", b_district.value);
  f.append("bc", b_city.value);
  f.append("bpc", b_pcode.value);

  f.append("oid", orderId);
  f.append("cb", cbox);
  f.append("sfn", s_fname.value);
  f.append("sln", s_lname.value);
  f.append("sl1", s_line1.value);
  f.append("sl2", s_line2.value);
  f.append("spro", s_province.value);
  f.append("sdis", s_district.value);
  f.append("sc", s_city.value);
  f.append("spc", s_pcode.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        Swal.fire({
          icon: "success",
          title: "You are ready for payments",
          text: "Please wait...",
          showConfirmButton: false,
          // timer: 2000,
        });
        window.location = "paymentProcess.php";
      }else{
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: true,
          // timer: 1500,
        });
      }
    }
  };
  r.open("POST", "payNowProcess.php", true);
  r.send(f);
}

function forgetOrder() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t == "success") {
        Swal.fire({
          icon: "success",
          title: "You are ready to a new Order",
          showConfirmButton: false,
          timer: 1000,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: true,
          // timer: 1500,
        });
      }
    }
  };

  r.open("GET", "forgetOrderProcess.php", true);
  r.send();
}

function updateOrderStatus(stetusID, oid) {
  var order_status = stetusID;
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t == "success") {
        window.location = "myorders.php";
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: true,
          // timer: 1500,
        });
      }
    }
  };

  r.open(
    "GET",
    "updateOrderStatusProcess.php?status=" + order_status + "&id=" + oid,
    true
  );

  r.send();
}

function payme() {}

function loadMyOrders() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      var row = document.getElementById("myOrdersTable");
      row.insertAdjacentHTML("beforeend", t);
    }
  };

  r.open("GET", "loadMyOrdersProcess.php", true);
  r.send();
}

function loadAllBooks() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      // var row = document.getElementById("shopBooksArea");
      // row.insertAdjacentHTML("beforeend", t);
    }
  };

  r.open("GET", "shop.php", true);
  r.send();
}

function basicSearch(x) {
  var text = document.getElementById("h_search").value;
  var category = document.getElementById("h_cat_select").value;

  var f = new FormData();
  f.append("t", text);
  f.append("c", category);
  f.append("page", x);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      document.getElementById("shopBooksArea").innerHTML = t;
    }
  };

  r.open("POST", "loadAllBooksProcess.php", true);
  r.send();
}

function checkValue(min, max, input) {
  if (input.value < min) {
    input.value = min;
    Swal.fire({
      icon: "warning",
      title: "Oops...",
      text: "There are no books under Rs. " + min + ".00",
      showConfirmButton: false,
      timer: 1500,
    });
    // alert("There are no books under Rs. " + min + ".00");
  } else if (input.value > max) {
    input.value = max;
    Swal.fire({
      icon: "warning",
      title: "Oops...",
      text: "There are no books over Rs. " + max + ".00",
      showConfirmButton: false,
      timer: 1500,
    });
    // alert("There are no books over Rs. " + max + ".00");
  }
}

function advancedSearch(pageNO) {
  var search_text = document.getElementById("aSearchText");
  var category = document.getElementById("aSearchCategory");
  var author = document.getElementById("aSearchAuthor");
  var language = document.getElementById("aSearchLanguage");
  var min = document.getElementById("minPrice");
  var max = document.getElementById("maxPrice");
  var pages = document.getElementById("selectPagesCount");
  var sort = document.getElementById("aSearchSortSelector");

  var f = new FormData();
  f.append("st", search_text.value);
  f.append("c", category.value);
  f.append("a", author.value);
  f.append("l", language.value);
  f.append("min", min.value);
  f.append("max", max.value);
  f.append("pc", pages.value);
  f.append("s", sort.value);
  f.append("page", pageNO);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      // alert(t);
      document.getElementById("advancedSearchResults").innerHTML = t;
    }
  };
  r.open("POST", "advancedSearchProcess.php", true);
  r.send(f);
}

function saveInvoice() {
  var element = document.getElementById('invoice');
  var opt = {
    margin:       0.5,
    filename:     'invoice.pdf',
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { scale: 2 },
    jsPDF:        { unit: 'in', format: 'A4', orientation: 'portrait' }
  };
   
  // New Promise-based usage:
  html2pdf().from(element).set(opt).save();
  
}

function showOrdersReport() {
  document.getElementById("orderReport").className = "row d-block";
  document.getElementById("booksReport").className = "row d-none";
  document.getElementById("customersReport").className = "row d-none";
  document.getElementById("stockReport").className = "row d-none";
}

function showBooksReport() {
  document.getElementById("orderReport").className = "row d-none";
  document.getElementById("booksReport").className = "row d-block";
  document.getElementById("customersReport").className = "row d-none";
  document.getElementById("stockReport").className = "row d-none";
}

function showCustomersReport() {
  document.getElementById("orderReport").className = "row d-none";
  document.getElementById("booksReport").className = "row d-none";
  document.getElementById("customersReport").className = "row d-block";
  document.getElementById("stockReport").className = "row d-none";
}

function showStockReport() {
  document.getElementById("orderReport").className = "row d-none";
  document.getElementById("booksReport").className = "row d-none";
  document.getElementById("customersReport").className = "row d-none";
  document.getElementById("stockReport").className = "row d-block";
}

// backend

function changeOrderStetus(oid) {
  var selector = document.getElementById("orderStetusSelecter");
  var f = new FormData();
  f.append("oid", oid);
  f.append("stetus", selector.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t == "success") {
        Swal.fire({
          icon: "success",
          title: "Oder Stetus Changed Successfully",
          showConfirmButton: false,
          timer: 1000,
        });
        setInterval(() => {
          window.location.reload();
        }, 1000);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: true,
          // timer: 1500,
        });
      }
    }
  };

  r.open("POST", "changeOrderStetusProcess.php", true);
  r.send(f);
}

function loadCustomers() {
  var stetus = document.getElementById("customerStetusSelector");
  var gender = document.getElementById("customerGenderSelector");
  var search_text = document.getElementById("customerSearchText");

  var f = new FormData();
  f.append("stetus", stetus.value);
  f.append("gender", gender.value);
  f.append("search", search_text.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      document.getElementById("customerTable").innerHTML = t;
    }
  };

  r.open("POST", "loadCustomersProcess.php", true);
  r.send(f);

  expandCustomers();
  var btn = document.getElementById("vcustomerbtn");
  var btn2 = document.getElementById("vcustomerbtn2");

  btn.classList.add("active");
  btn2.classList.add("active");
}

function expandMenu(menuItem) {
  menuItem.classList.toggle("d-none");
}

function expandOrders() {
  var menuList = document.getElementById("orders-menu");
  var menuList2 = document.getElementById("orders-menu2");

  expandMenu(menuList);
  expandMenu(menuList2);
}

function expandBooks() {
  var menuList = document.getElementById("books-menu");
  var menuList2 = document.getElementById("books-menu2");

  expandMenu(menuList);
  expandMenu(menuList2);
}

function expandCustomers() {
  var menuList = document.getElementById("customers-menu");
  var menuList2 = document.getElementById("customers-menu2");

  expandMenu(menuList);
  expandMenu(menuList2);
}

function loadDashboard() {
  var btn = document.getElementById("overviewbtn");
  var btn2 = document.getElementById("overviewbtn2");

  btn.classList.add("active");
  btn2.classList.add("active");
}

function loadAddCustomers() {
  expandCustomers();
  var btn = document.getElementById("addcustomerbtn");
  var btn2 = document.getElementById("addcustomerbtn2");

  btn.classList.add("active");
  btn2.classList.add("active");
}

function loadOrders(page) {
  var stetus = document.getElementById("orderStetusSelector");
  var customer = document.getElementById("customerSelector");
  var search_text = document.getElementById("ordersSearch");

  var f = new FormData();
  f.append("page", page);
  f.append("ost", stetus.value);
  f.append("customer", customer.value);
  f.append("text", search_text.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      // alert(t);
      document.getElementById("ordersTable").innerHTML = t;
    }
  };
  r.open("POST", "loadOrdersProcess.php", true);
  r.send(f);

  expandOrders();
  var btn = document.getElementById("orderbtn");
  var btn2 = document.getElementById("orderbtn2");

  btn.classList.add("active");
  btn2.classList.add("active");
}

function loadCategories() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      var row = document.getElementById("categoryTable");
      row.insertAdjacentHTML("beforeend", t);
    }
  };

  r.open("GET", "loadCategoriesProcess.php", true);
  r.send();

  expandBooks();
  var btn = document.getElementById("categoriesbtn");
  var btn2 = document.getElementById("categoriesbtn2");

  btn.classList.add("active");
  btn2.classList.add("active");
}

function loadAuthors() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      var row = document.getElementById("authorTable");
      row.insertAdjacentHTML("beforeend", t);
    }
  };

  r.open("GET", "loadAuthorsProcess.php", true);
  r.send();

  expandBooks();
  var btn = document.getElementById("authorsbtn");
  var btn2 = document.getElementById("authorsbtn2");

  btn.classList.add("active");
  btn2.classList.add("active");
}

function loadLanguages() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      var row = document.getElementById("languageTable");
      row.insertAdjacentHTML("beforeend", t);
    }
  };

  r.open("GET", "loadLanguagesProcess.php", true);
  r.send();

  expandBooks();
  var btn = document.getElementById("languagesbtn");
  var btn2 = document.getElementById("languagesbtn2");

  btn.classList.add("active");
  btn2.classList.add("active");
}

function loadReports() {
  // var r = new XMLHttpRequest();

  // r.onreadystatechange = function () {
  //   if (r.status == 200 && r.readyState == 4) {
  //     var t = r.responseText;
  //     var row = document.getElementById("languageTable");
  //     row.insertAdjacentHTML("beforeend", t);
  //   }
  // };

  // r.open("GET", "loadLanguagesProcess.php", true);
  // r.send();

  expandBooks();
  var btn = document.getElementById("reportsbtn");
  var btn2 = document.getElementById("reportsbtn2");

  btn.classList.add("active");
  btn2.classList.add("active");
}

function loadAddBooks() {
  expandBooks();
  var btn = document.getElementById("addbooksbtn");
  var btn2 = document.getElementById("addbooksbtn2");

  btn.classList.add("active");
  btn2.classList.add("active");
}

function loadBooks() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      var row = document.getElementById("booksTable");
      row.insertAdjacentHTML("beforeend", t);
    }
  };

  r.open("GET", "loadBooksProcess.php", true);
  r.send();

  expandBooks();
  var btn = document.getElementById("allbooksbtn");
  var btn2 = document.getElementById("allbooksbtn2");

  btn.classList.add("active");
  btn2.classList.add("active");
}

function adminBookFilter() {
  var author = document.getElementById("authorSelector");
  var tableB = document.getElementById("booksTable");
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (author.value == 0) {
        t = "Please Select Author";
        alertBox = document.getElementById("viewBookAlertBox");
        alertBox.classList.remove("d-none");
        alertBox.classList.add("d-block");
        document.getElementById("viewBookAlert").innerHTML = t;
      } else {
        document.getElementById("booksTable").innerHTML = t;
      }
    }
  };

  r.open("GET", "adminBookFilterProcess.php?aid=" + author.value, true);
  r.send();
}

function deleteAuthor(author) {
  var authorId = author.id;
  var r = new XMLHttpRequest();

  if (authorId == 1) {
    alert("Can't Delete This");
  } else {
    r.onreadystatechange = function () {
      if (r.status == 200 && r.readyState == 4) {
        var t = r.responseText;
        if (t == "success") {
          window.location.reload();
        } else {
          alert(t);
        }
      }
    };

    r.open("GET", "deleteAuthorProcess.php?id=" + authorId, true);
    r.send();
  }
}

function deleteCategory(category) {
  var categoryId = category.id;
  var r = new XMLHttpRequest();

  if (categoryId == 1) {
    alert("Can't Delete This");
  } else {
    r.onreadystatechange = function () {
      if (r.status == 200 && r.readyState == 4) {
        var t = r.responseText;
        if (t == "success") {
          window.location.reload();
        } else {
          alert(t);
        }
      }
    };

    r.open("GET", "deleteCategoryProcess.php?id=" + categoryId, true);
    r.send();
  }
}

function deleteLanguage(language) {
  var languageId = language.id;
  var r = new XMLHttpRequest();

  if (languageId == 1) {
    alert("Can't Delete This");
  } else {
    r.onreadystatechange = function () {
      if (r.status == 200 && r.readyState == 4) {
        var t = r.responseText;
        if (t == "success") {
          window.location.reload();
        } else {
          alert(t);
        }
      }
    };

    r.open("GET", "deleteLanguageProcess.php?id=" + languageId, true);
    r.send();
  }
}

var customerEmail = "";

function selectCustomer(row) {
  checkbox = row.querySelector('input[type="checkbox"]');

  if (checkbox.checked) {
    customerEmail = row.cells[3].innerHTML;
    row.classList.add("table-active");
  } else {
    customerEmail = "";
    row.classList.remove("table-active");
  }
}

function changeStetus(btn) {
  var cemail = btn.id;
  var customerStetus = document.getElementById("select" + cemail);
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        window.location.reload();
      } else {
        alert(customerStetus.value);
      }
    }
  };

  r.open(
    "GET",
    "stetusUpdateProcess.php?stetus=" +
      customerStetus.value +
      "&email=" +
      cemail,
    true
  );

  r.send();
}

function addCustomerDetails() {
  // var profile_img = document.getElementById("customer-propicuploader");
  var first_name = document.getElementById("customer-fname");
  var last_name = document.getElementById("customer-lname");
  var email_address = document.getElementById("customer-email");
  var phone_no = document.getElementById("customer-phone");
  var birth_day = document.getElementById("customer-bday");
  var gender = document.getElementById("customer-gender");

  var f = new FormData();
  // f.append("img", profile_img.files[0]);
  f.append("fn", first_name.value);
  f.append("ln", last_name.value);
  f.append("ea", email_address.value);
  f.append("mn", phone_no.value);
  f.append("bd", birth_day.value);
  f.append("g", gender.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;

      if (t == "Register success") {
        Swal.fire({
          icon: "success",
          title: "Customer Registration Success",
          showConfirmButton: false,
          timer: 1500,
        });
        setInterval(() => {
          window.location = "customers.php";
        }, 1500);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: t,
          showConfirmButton: false,
          timer: 1500,
        });
      }
    }
  };
  r.open("POST", "addCustomerDetailsProcess.php", true);
  r.send(f);
}

function addAuthors() {
  var author_name = document.getElementById("authorName");
  var author_disc = document.getElementById("authorDisc");

  var f = new FormData();
  f.append("an", author_name.value);
  f.append("ad", author_disc.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        window.location.reload();
      } else {
        document.getElementById("authorMsg").innerHTML = t;
        document.getElementById("authorMsgDiv").className = "d-block";
      }
    }
  };
  r.open("POST", "addAuthorsProcess.php", true);
  r.send(f);
}

function addCategories() {
  var category_name = document.getElementById("categoryName");
  var category_disc = document.getElementById("categoryDisc");

  var f = new FormData();
  f.append("cn", category_name.value);
  f.append("cd", category_disc.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        window.location.reload();
      } else {
        document.getElementById("categoryMsg").innerHTML = t;
        document.getElementById("categoryMsgDiv").className = "d-block";
      }
    }
  };
  r.open("POST", "addCategoriesProcess.php", true);
  r.send(f);
}

function addLanguages() {
  var language_name = document.getElementById("languageName");
  var language_disc = document.getElementById("languageDisc");

  var f = new FormData();
  f.append("ln", language_name.value);
  f.append("ld", language_disc.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        window.location.reload();
      } else {
        document.getElementById("languageMsg").innerHTML = t;
        document.getElementById("languageMsgDiv").className = "d-block";
      }
    }
  };
  r.open("POST", "addLanguageProcess.php", true);
  r.send(f);
}

function hideauthorMsg() {
  document.getElementById("authorMsgDiv").className = "d-none";
}
function hideCategoryMsg() {
  document.getElementById("categoryMsgDiv").className = "d-none";
}
function hideLanguageMsg() {
  document.getElementById("languageMsgDiv").className = "d-none";
}

var options = {
  chart: {
    type: "area",
    zoom: {
      enabled: false,
    },
  },
  dataLabels: {
    enabled: false,
  },
  toolbar: {
    show: false,
  },
  stroke: {
    width: 4,
    curve: "smooth",
  },
  series: [
    {
      name: "sales",
      data: [30, 40, 35, 50, 5, 25, 0],
    },
  ],
  xaxis: {
    categories: [2018, 2019, 2020, 2021, 2022, 2023, 2024],
  },
};

var chart = new ApexCharts(document.querySelector(".chart"), options);

chart.render();

var chart = new ApexCharts(document.querySelector(".chart2"), options);

chart.render();

function deleteCustomer(deleteID) {
  var uid = deleteID.id;
  var f = new FormData();
  f.append("email", uid);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        alert(t);
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else {
        alert(t);
      }
    }
  };
  r.open("POST", "deleteCustomerProcess.php", true);
  r.send(f);
}

function test1(testID) {
  var email = testID.id;
  alert(email);
}

function addBook() {
  var CheckboxForm = document.getElementById("checkboxForm");
  var inputs = CheckboxForm.getElementsByTagName("input");
  var checks = new Array();

  for (let index = 0; index < inputs.length; index++) {
    if (inputs[index].checked) {
      checks.push(inputs[index].value);
    }
  }

  var book_name = document.getElementById("bookName");
  var book_disc = document.getElementById("bookDisc");
  var book_pages = document.getElementById("bookPages");
  var book_publisher = document.getElementById("bookPublisher");
  var book_isbn = document.getElementById("bookISBN");
  var book_published_date = document.getElementById("bookPublishedDate");
  var book_language = document.getElementById("bookLanguage");
  var book_author = document.getElementById("bookAuthor");
  var book_price = document.getElementById("bookPrice");
  var book_sale_price = document.getElementById("bookSalePrice");
  var book_qty = document.getElementById("bookQty");
  var book_sku = document.getElementById("bookSKU");
  var book_weight = document.getElementById("bookWeight");
  var book_dimention = document.getElementById("bookDimention");
  var book_img_uploader = document.getElementById("bookImgUploader");

  var f = new FormData();

  f.append("bn", book_name.value);
  f.append("bdisc", book_disc.value);
  f.append("bpage", book_pages.value);
  f.append("bpub", book_publisher.value);
  f.append("bisbn", book_isbn.value);
  f.append("bpd", book_published_date.value);
  f.append("bl", book_language.value);
  f.append("ba", book_author.value);
  f.append("bprice", book_price.value);
  f.append("bsprice", book_sale_price.value);
  f.append("bq", book_qty.value);
  f.append("bsku", book_sku.value);
  f.append("bw", book_weight.value);
  f.append("bdimen", book_dimention.value);
  f.append("img", book_img_uploader.files[0]);
  f.append("cat", checks);
  f.append("catlength", checks.length);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        window.location = "all-books.php";
      } else {
        alertBox = document.getElementById("addBookAlertBox");
        alertBox.classList.remove("d-none");
        alertBox.classList.add("d-block");
        document.getElementById("addBookAlert").innerHTML = t;
      }
    }
  };
  r.open("POST", "addBookProcess.php", true);
  r.send(f);
}

function updateBook(bid) {
  var book_id = bid.id;
  var CheckboxForm = document.getElementById("checkboxForm");
  var inputs = CheckboxForm.getElementsByTagName("input");
  var checks = new Array();

  for (let index = 0; index < inputs.length; index++) {
    if (inputs[index].checked) {
      checks.push(inputs[index].value);
    }
  }

  var book_name = document.getElementById("bookName");
  var book_disc = document.getElementById("bookDisc");
  var book_pages = document.getElementById("bookPages");
  var book_publisher = document.getElementById("bookPublisher");
  var book_isbn = document.getElementById("bookISBN");
  var book_published_date = document.getElementById("bookPublishedDate");
  var book_language = document.getElementById("bookLanguage");
  var book_author = document.getElementById("bookAuthor");
  var book_price = document.getElementById("bookPrice");
  var book_sale_price = document.getElementById("bookSalePrice");
  var book_qty = document.getElementById("bookQty");
  var book_sku = document.getElementById("bookSKU");
  var book_weight = document.getElementById("bookWeight");
  var book_dimention = document.getElementById("bookDimention");
  var book_img_uploader = document.getElementById("bookImgUploader");

  var f = new FormData();

  f.append("bn", book_name.value);
  f.append("bdisc", book_disc.value);
  f.append("bpage", book_pages.value);
  f.append("bpub", book_publisher.value);
  f.append("bisbn", book_isbn.value);
  f.append("bpd", book_published_date.value);
  f.append("bl", book_language.value);
  f.append("ba", book_author.value);
  f.append("bprice", book_price.value);
  f.append("bsprice", book_sale_price.value);
  f.append("bq", book_qty.value);
  f.append("bsku", book_sku.value);
  f.append("bw", book_weight.value);
  f.append("bdimen", book_dimention.value);
  f.append("img", book_img_uploader.files[0]);
  f.append("cat", checks);
  f.append("catlength", checks.length);
  f.append("bid", book_id);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        window.location = "all-books.php";
      } else {
        alertBox = document.getElementById("addBookAlertBox");
        alertBox.classList.remove("d-none");
        alertBox.classList.add("d-block");
        document.getElementById("addBookAlert").innerHTML = t;
      }
    }
  };
  r.open("POST", "updateBookProcess.php", true);
  r.send(f);
}

var alertBox;
function hideAlert() {
  alertBox.classList.remove("d-block");
  alertBox.classList.add("d-none");
}

function bookFeatured(bstar) {
  var star_icon = document.getElementById("bstar");
  var bid = bstar.id;

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "featured") {
        window.location.reload();
      } else if ("notfeatured") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };
  r.open("GET", "featuredBookProcess.php?bid=" + bid, true);
  r.send();
}

function deleteBook(bookId) {
  // var bookId = book.id;
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "deleteBookProcess.php?id=" + bookId, true);
  r.send();
}

function checkInput(input) {
  inputValue = input.value;
  if (inputValue < 0) {
    input.value = "";
  }
}


