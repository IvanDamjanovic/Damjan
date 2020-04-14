console.log('Hello world');

var broj=2;
var ime='Marija';
var zaposlen=true;
var placa=8756.98;

console.log('broj: ' + typeof broj);
console.log('ime: ' + typeof ime);
console.log('zaposlen: ' + typeof zaposlen);
console.log('placa: ' + typeof placa);

var niz=[2,3,2,3,2];

console.log('niz: ' + typeof niz);

//JSON
var objekt={ime: 'Pero', prezime: 'Perić'};

console.log('objekt: ' + typeof objekt);

var b=3;
var uvjet=b>3;
if(uvjet){
    console.log("OK");
}

switch (b) {
    case 3:
        console.log("OK");
        break;

    default:
        console.log("NE");
}

for(var i=0;i<10;i++){
    console.log(i);
}
var broj=0;
while(true){
console.log(++broj);
if(broj>10){
    break;
}
}

//function postaviNaslov(){
//    document.getElementById('naslov').innerHTML='Hello';
//}

//document.getElementById('gumb').addEventListener('click',postaviNaslov);

document.getElementById('gumb').addEventListener('click',function(){
    document.getElementById('naslov').innerHTML='Hello';
});



