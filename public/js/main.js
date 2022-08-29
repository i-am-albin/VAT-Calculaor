    
    

window.addEventListener('load', function() {
    
clean();

})

function clean(){


    document.getElementById('netAmount').value="";
    document.getElementById('vat').value="";
    document.getElementById('grossAmount').value="";
    document.getElementById('inputGiven').value=""; 
    document.getElementById('inputField').value="";
}

function insert(num){
    var previousResult = document.getElementById('inputField').value;
    document.getElementById('inputField').value = previousResult + num;
}

function rateOfVat() {

    var rate = document.getElementById('rangeVat').value;
    document.getElementById('vatValue').textContent = rate+'%';
}

function includeVAT(){


    var netAmount = document.getElementById('inputField').value;

    if(netAmount && /^[+-]?([0-9]*[.])?[0-9]+$/.test(netAmount)){

        var rangeVat=document.getElementById('rangeVat').value;
        var rate=parseFloat(rangeVat)/100;
        var netAmount = document.getElementById('inputField').value;
        var vat=parseFloat(netAmount)*parseFloat(rate);
        var grossAmount=parseFloat(netAmount)+parseFloat(vat);
        document.getElementById('calculatorDiv').style.display = 'none';
        document.getElementById('resultDiv').style.display = 'block';
        
        document.getElementById('netAmount').value=netAmount;
        document.getElementById('vat').value=vat;
        document.getElementById('rateVat').textContent = document.getElementById('rangeVat').value+'%';
        document.getElementById('grossAmount').value=grossAmount;
        document.getElementById('inputGiven').value=netAmount;

        createData(rangeVat,netAmount,type='Include');

    } else {


        alert("Input is Required");

    }

   


}

function excludeVAT(){


    var netAmount = document.getElementById('inputField').value;

    if(netAmount && /^[+-]?([0-9]*[.])?[0-9]+$/.test(netAmount)){

        var rangeVat=document.getElementById('rangeVat').value;
        var rate = parseFloat(rangeVat)/100;
        
        var findVat=netAmount/(1+parseFloat(rate));
        var excludeVat=(netAmount-findVat)*(-1);
        //var grossAmount=parseFloat(netAmount)+parseFloat(vat);
        document.getElementById('calculatorDiv').style.display = 'none';
        document.getElementById('resultDiv').style.display = 'block';
        //console.log(Math.abs(excludeVat.toFixed(2)));

        document.getElementById('netAmount').value=netAmount;
        document.getElementById('vat').value=Math.abs(excludeVat.toFixed(2));
        document.getElementById('rateVat').textContent = document.getElementById('rangeVat').value+'%';
        document.getElementById('grossAmount').value=netAmount;
        document.getElementById('inputGiven').value=netAmount; 

        createData(rangeVat,netAmount,type='Exclude');        
    } else {

        alert("Input is Required");

    }   


}

function startNew(){

    document.getElementById('calculatorDiv').style.display = 'block';
    document.getElementById('resultDiv').style.display = 'none';
    clean();

}

function createData(rangeVat,inputAmount,type){

    var xhr = new XMLHttpRequest();
    xhr.open("POST", 'create', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({
        rangeVat: rangeVat,inputAmount:inputAmount,type:type
    }));   
     
}
