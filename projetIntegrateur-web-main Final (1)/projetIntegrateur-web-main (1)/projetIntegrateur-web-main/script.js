

var countDate = new Date('December 25, 2024 00:00:00').getTime();
function dealTimer(){
    var now = new Date().getTime();
        gap = countDate - now;

        var second = 1000;
        var minute = second * 60;
        var hour = minute * 60;
        var day = hour * 24;

        var d = Math.floor(gap / (day));
        var h = Math.floor((gap % (day)) / (hour));
        var m = Math.floor((gap % (hour)) / (minute));
        var s = Math.floor((gap % (minute)) / second);

        d = d.toString().padStart(2, '0');
        h = h.toString().padStart(2, '0');
        m = m.toString().padStart(2, '0');
        s = s.toString().padStart(2, '0');

        document.getElementById('day').innerText = d;
        document.getElementById('hour').innerText = h;
        document.getElementById('minute').innerText = m;
        document.getElementById('second').innerText = s;
}

function dealsTimer()
{

let  nowTime = new Date().getTime();
let timers = document.getElementsByClassName('deals-timer');
for (let i = 0; i < timers.length; i++) {
  let endDate = new Date(timers[i].getAttribute("value")).getTime();
  let gapTime = endDate - nowTime;
  var second = 1000;
  let minute = second * 60;
  let hour = minute * 60;
  let day = hour * 24;

  let d = Math.floor(gapTime / (day));
  let h = Math.floor((gapTime % (day)) / (hour));
  let m = Math.floor((gapTime % (hour)) / (minute));
  let s = Math.floor((gapTime % (minute)) / second);
  timers[i].innerText = "L'offre se termine dans " + d + ":" + h + ": " + m + ": " + s;
  }
}


setInterval(function(){
    dealTimer();
    dealsTimer();    
},1000);


document.getElementById('show-password').addEventListener('change', function() {
    var passwordField = document.getElementById('mdp');
    if (this.checked) {
      passwordField.type = 'text';
    } else {
      passwordField.type = 'password';
    }
  });
function updateCartCount(count) {
  const cartCountElement = document.getElementById('cartCount');
  if (cartCountElement) {
      cartCountElement.textContent = count;
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const successMessage = document.querySelector('.success-message');
  if (successMessage) {
      const newCount = successMessage.dataset.cartCount;
      if (newCount) {
          updateCartCount(newCount);
      }
  }
});
function toggleMobileMenu() {
  const mobileMenu = document.getElementById('mobileMenu');
  mobileMenu.classList.toggle('active');
}
