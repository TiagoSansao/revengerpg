let quadrado = document.getElementsByClassName('quadrado'); // Array com todos quadrados do código 

let marcados = [0, 0, 0, 0, 0, 0, 0, 0, 0]; // Quadrados marcados pelo jogador, 0 significa vazio, 1 significa marcado pelo jogador e 2 pelo computador
let vitoria = 0; // Essa variável guarda um número utilizado para saber se o jogo teve um vencedor ou empatou, para evitar erro na lógica do jogo

for (let q = 0; q < 9; q++) {
    quadrado[q].addEventListener("mouseover", function() { quadrado[q].style.background = 'gray'; }); // Mudar cor ao passar mouse em cima
    quadrado[q].addEventListener("mouseout", function() {quadrado[q].style.background = "white"; });  // Voltar cor padrão ao remover o mouse
    quadrado[q].addEventListener("click", function bolinha() { // Marcar um quadrado
        vitoria = 0; // Indica que ninguém venceu ainda
        if (marcados[q] == 0) { // Caso o quadrado não esteja marcado, irá marcar com uma bolinha
            let bolinha = document.createElement("div"); // Criar uma div chamada bolinha
            bolinha.classList.add("bolinha"); // Adicionar o elemento em uma classe que dará a forma geométrica
            quadrado[q].appendChild(bolinha); // Inserir o elemento criado dentro do quadrado
            marcados[q] = 1; // Informa que o quadrado está marcado pelo jogador
            new Audio('sonoro/jogoclick.mp3').play();
            checarVitoria(1); // Checa se alguém já venceu ANTES do computador jogar.
            if (vitoria == 0) { // Se ninguém tiver ainda vencido, o computador pode jogar
                vezDoComputador(); // Chama uma função para o computador fazer sua jogada
            }
        } else { // Caso o quadrado já esteja marcado irá mudar o fundo para vermelho para sinalizar
            new Audio('sonoro/jogoerro.mp3').play()
            quadrado[q].style.background = "red"; // Alterar a cor de fundo do quadrado para vermelho
            setTimeout(function() {quadrado[q].style.background = 'white';}, 100); // Após 100 milisegundos com a cor vermelha, voltar para a branca
        }
    }
    );
};

function checarVitoria(p) {
        for (let mutiplo = 0; mutiplo < 9; mutiplo = mutiplo + 3) { // Estrutura de repetição com os múltimos de 3 de 0 a 9 para evitar a repetição de códigos
            if (marcados[mutiplo] == p && marcados[mutiplo+1] == p && marcados[mutiplo+2] == p ) { // Checar se linha de quadrados está marcada pelo jogador
                if (p == 1) { // Checa o vencedor foi o player
                    venceu();                       
                } 
                if (p == 2) { // Executa caso o jogador tenha perdido
                    perdeu();
                }
            }
        }
        for (let mutiplo = 0; mutiplo < 3; mutiplo++) { // Estrutura de repetição que se auto incrementa com 1 toda checagem
            if (marcados[mutiplo] == p && marcados[mutiplo+3] == p && marcados[mutiplo+6] == p ) { // Checar se coluna de quadrados está marcada pelo jogador
                if (p == 1) { // Checa o vencedor foi o player
                    venceu();
                }
                if (p == 2) { // Executa caso o jogador tenha perdido
                    perdeu();
                }
            }
        }
        for (let mutiplo = 0; mutiplo < 3; mutiplo = mutiplo + 2) { // Estrutura de repetição, no primeiro teste lógico o mutiplo vale 0 e no segundo teste lógico vale 2
            if (marcados[mutiplo] == p && marcados[4] == p && marcados[8 - mutiplo] == p ) { // Checar se diagonal de quadrados está marcada pelo jogador
                if (p == 1) { // Checa o vencedor foi o player
                    venceu();
                } 
                if (p == 2) { // Executa caso o jogador tenha perdido
                    perdeu();
                }
            }
        }
    }
function vezDoComputador() {  // Função chamada após o jogador fazer sua jogada
    let possibilidades = []; // Essa array vai armazenar os quadrados vazios
    let xizinho = document.createElement('div'); // Criar o elemento que fará o X
    xizinho.innerHTML = 'X'; // Escrever a letra X no elemento criado
    xizinho.classList.add('xizinho'); // Adicionar o elemento numa classe CSS
    
    for (let q in marcados) { // Estrutura de repetição com todos os quadrados
        if (marcados[q] == 0) { // Checa se o quadrado tá vazio, (0 == vazio)
            possibilidades.push([q]); // Se o quadrado estiver vazio, o número dele é adicionado na array de possiblidades
        }
    }
    if (possibilidades.length == 0 && vitoria == 0) { // Se não houver mais possibilidades e ninguém ainda tiver ganhado, deu empate
        velha();
    }
    let aleatorio = possibilidades[Math.floor(Math.random() * possibilidades.length)]; // Um quadrado aleatório dentro das possibilidades será gerado
    quadrado[aleatorio].appendChild(xizinho); // O quadrado escolhido vai rececber o "X"
    marcados[aleatorio] = 2; // O quadrado que recebeu o X receberá o valor 2 na Array de marcados para sinalizar que o quadrado foi marcado pelo computador
    checarVitoria(2) // Checa se o computador venceu após sua jogada
}
function reiniciar() { // Função chamada após o jogo acabar
    marcados = [0, 0, 0, 0, 0, 0, 0, 0, 0]; // Seta como vazio os quadrados
    for (let i in quadrado) { // Remove todas divs criadas para figurar o "xizinho" e a  "bolinha";
        if (quadrado[i].lastChild) { // Checa se o quadrado tem uma div dentro dele
            quadrado[i].removeChild(quadrado[i].lastChild); // Se tiver, essa div é removida
        }
    }
}

let interface = document.getElementById('interface');



function fimMensagem(resultado) {
    let texto = document.createElement('div'); // Cria uma div com o nome texto
    texto.innerHTML = "<p>" + resultado + "</p>"; // A div recebe o resultado da partida que é passado quando a partida acaba 
    texto.classList.add('fimMensagem'); // A div recebe uma classe que já está customizada no CSS
    interface.appendChild(texto); // A div interface receberá a div criada nessa função
    setTimeout(function() {interface.removeChild(texto)}, 1000); // Após 1 segundo a div criada nessa função será removida
}


function venceu() { // Função executada caso jogador vença
    new Audio('sonoro/jogovitoria.mp3').play()
    vitoria = 1; // Armazena que a vitória foi do jogador
    reiniciar(); // Chama a função para reiniciar o jogo
    fimMensagem('Vitória')
}
function perdeu() { // Função executada caso jogador perca
    new Audio('sonoro/jogoderrota.mp3').play()
    vitoria = 2; // Armazena que a vitória foi do computador
    reiniciar(); // Chama a função para reiniciar o jogo
    fimMensagem('Derrota')
}
function velha() { // Função executada caso empate
    new Audio('sonoro/jogovitoria.mp3').play()  
    vitoria = 3; // Armazena que foi um empate
    reiniciar(); // Chama a função para reiniciar o jogo
    fimMensagem('Empate')
}

/* Possibilidade de arrays 

   0 1 2 / 3 4 5 / 6 7 8 --- LINHA
   0 3 6 / 1 4 7 / 2 5 8  --- COLUNA
   0 4 8 / 2 4 6 --- DIAGONAL

*/
/* +1 -

   1 2 3 / 4 5 6 / 7 8 9 --- LINHA
   1 4 7 / 2 5 8 / 3 6 9 --- COLUNA
   1 5 9 / 3 6 7 --- DIAGONAL

*/