let nomevariavel = 1;
let nomevariavel2 = "rhauan";
let nomevariavel3 = 1.8;
let nomevariavel4 = true;

// Variavel que não pode ter mais de 1 valor igual

const nome = "Rhauan";

// Variavel que não altera o valor

// (A variavel VAR pode ter o mesmo valor em mais de 1 variavel)

// Operações Matematicas

let soma = 3+5; //8
let subtracao = 5-3; //2
let multiplicacao = 3*5; //15
let divisao = 10/2; //5

// Juntar Textos

let primeironome = "Rhauan";
let sobrenome = "Santos";
let nomecompleto = primeironome + sobrenome;

// Funções
// Função sem parametros
function imprimirMsg(){
    console.log("Hello Word!")
}

// Funções com parametros

function somarValores(valor1,valor2){
    let soma = 183+76;
    console.log("O resultado da soma é:"+ soma);
}

// A Condicional é executada com base de um criterio

let n1 = 15;
let n2 = 45;
if(n1=10){
    console.log("Irei para praia!");
}else{
    console.log("Fico em casa!");
}

// if aninhado
// se n1 é maior que 12 e n2 maior que 48
if(n1>12 && n2>48){
    console.log("Irei para a praia!");
    // se n1 é maior ou igual a 15 e n2 menor que 45
}else if (n1>=15 && n2<45){
    console.log("Vou ao cinema!");
    // se n1 for maior que 14 e n2 igual 45 e se n2 for maior que n1 ou n1 maior ou igual a 15
}else if ((n1>14 && n2==45) && (n2>n1 || n1>=15)){
    console.log("Vou ao shopping!");
}else{
    console.log("Fico em casa!");
}

// Objeto

let carro = {
    cor: "preto",
    placa: "HAB4909",
    modelo: "Fusca",
    KMs: 15000,
    som: true
};
console.log(carro.cor+carro.modelo+carro.placa);