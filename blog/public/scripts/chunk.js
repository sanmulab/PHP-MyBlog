var array = ['57db847cd8bc1.jpg','57fc847cd4bc1.jpg','57fc847cd8bc1.jpg','547438bb72145.jpg','5475971e0005a.jpg','547597176a433.jpg','5475971966d55.jpg','drv6hu47cdbc1.jpg','rtfc847cp98h1.jpg'];
var random = Math.floor(Math.random()*array.length);
$('#login-main').css('background-image','url(public/images/background/' + array[random] + ')');
console.log(array[random]);