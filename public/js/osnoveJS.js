/*
komentar više linija
Čitati
https://github.com/tjakopec/CistiJS
https://github.com/tjakopec/OSC3JS
Za one koji će se htjeti detaljnije baviti s JS
https://github.com/tjakopec/OSC3JST
*/

// komentar jedna linija



//alert('Hello world;'); // komentar
//prompt('Unesi ime');
//confirm('Jesi li siguran');

//var i=1; //var se ne preporuča više koristiti svuda
let i=1;
//document.write(typeof(i));

console.log(i + ': ' + typeof(i));
i=1.1;
console.log(i + ': ' + typeof(i));
i='Osijek';
console.log(i + ': ' + typeof(i));
i=true;
console.log(i + ': ' + typeof(i));
i=[1,2];
console.log(i + ': ' + typeof(i));
i=[];
i['kljuc']='Vrijednost';
console.log(i + ': ' + typeof(i));
console.log(i['kljuc'] + ': ' + typeof(i['kljuc']));
i={ime:'Pero'};
console.log(i + ': ' + typeof(i));
console.log(typeof(is));

/*
let ime=prompt('Unesi ime');
if(ime==='Tomislav'){
    console.log('OK');
}else{
    console.log('NE');
}
console.log(ime==='Tomislav' ? 'OK' : 'NE'); 
*/
for(let i=0;i<10;i++){
    console.log(i);
}
i=0;
while(true){
    console.log(i)
    if(++i>100){
        break;
    }
} 