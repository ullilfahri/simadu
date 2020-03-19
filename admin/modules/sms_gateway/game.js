var angka=20;
var atas=5;
var kiri=10;
var score = 0;
//var waktu = 20;
var waktu_habis = 0;
function start(){
 bill = new pindah();
 bill2 = new timer();
 //.getElementById("score").value = 0;
 //document.getElementById("time").value = 0;
 
}
function nilai(){
 document.getElementById("score").value =  score;
 //document.getElementById("gambar").style.color = blue;
 score++;
}
function timer(){
  waktu_habis = document.getElementById("time").value = angka;
 angka--;
 var hasil = document.getElementById("score").value;
 if(waktu_habis==0){
 if(hasil<20){
  alert("game over!!!");
  angka=0; document.getElementById("time").value= angka;
 }else{
  alert("you win!!");
  angka=0; document.getElementById("time").value= angka;
 }
 }
 if(waktu_habis==0){
  setTimeout("", 1000);
 }else{
 setTimeout("timer()", 1000);
 }
}
var parameter_kiri = false;
var parameter_atas = false;
function pindah(){
 var gambar = document.getElementById("gambar");
 gambar.style.position = "fixed";
 gambar.style.marginLeft = kiri+"px";
 gambar.style.marginTop = atas+"px";
 if(kiri==900){
  parameter_kiri =true;
 }else if(kiri==10){
  parameter_kiri=false;
 }
 if(atas==250){
  parameter_atas=true;
 }else if(atas==100){
  parameter_atas=false;
 }
 if(parameter_kiri){
  kiri-=1;
 }else{
  kiri+=1;
 }
 if(parameter_atas){
 if(kiri==900){
  atas-=20;
 }else if(kiri==10){
  atas-=20;
 }
 }else{
   if(kiri==900){
  atas+=20;
 }else if(kiri==10){
  atas+=20;
 }

 }
 
 setTimeout("pindah()", 1/1000); 
 }