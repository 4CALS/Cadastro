document.addEventListener("DOMContentLoaded", function () {
  const funcao = document.getElementById("funcao")
  const campoTurma = document.getElementById("campoTurma")
  const form = document.getElementById("cadastroForm")
  const mensagem = document.getElementById("mensagem")
  const limparBtn = document.getElementById("limpar")
  const nomeInput = document.getElementById("nome")
  const keyboard = document.getElementById("keyboard")

  // Exibe campo de turma apenas se for estudante
  funcao.addEventListener("change", () => {
    campoTurma.style.display = funcao.value === "estudante" ? "flex" : "none"
  })

  // Submissão do formulário
  form.addEventListener("submit", function (e) {
    e.preventDefault()
    const dados = new FormData(form)

    // Verificar e alterar o valor do campo turma, caso necessário
    if (funcao.value === "funcionario" || funcao.value === "convidado") {
      dados.set('turma', funcao.value) // Atribui o valor da função ao campo "turma"
    }

    fetch("cadastrar.php", {
      method: "POST",
      body: dados
    })
      .then(res => res.text())
      .then((resposta) => {
        if (resposta.trim() === "duplicado") {
          mensagem.textContent = "Nome já cadastrado!"
          mensagem.style.display = "block"
          mensagem.style.background = "#f59f9f"
          mensagem.style.color = "#fff"
          mensagem.style.border = "1px solid #e57373"
          nomeInput.focus()
        } else {
          form.reset()
          campoTurma.style.display = "none"
          mensagem.textContent = "Adicionado com sucesso!"
          mensagem.style.display = "block"
          mensagem.style.background = "#d7f7dc"
          mensagem.style.color = "#2c662d"
          mensagem.style.border = "1px solid #a8e6a3"
        }

        setTimeout(() => {
          mensagem.style.display = "none"
        }, 3000)
      })
  })

  // Botão de limpar
  limparBtn.addEventListener("click", function () {
    form.reset()
    campoTurma.style.display = "none"
    mensagem.style.display = "none"
    keyboard.style.display = "flex" // Garante que o teclado não desapareça
  })

  // Mostrar teclado ao carregar a página e quando focar no campo nome
  keyboard.style.display = "flex" // O teclado aparece assim que a página carrega

  // Layout com letras maiúsculas
  const layout = [
    ["Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P"],
    ["A", "S", "D", "F", "G", "H", "J", "K", "L", "Ç"],
    ["Z", "X", "C", "V", "B", "N", "M", ".", "-", "⌫"],
    ["SPACE"]
  ]

  // Criar teclado virtual
  function createKeyboard() {
    keyboard.innerHTML = ""
    layout.forEach(row => {
      const rowEl = document.createElement("div")
      rowEl.className = "keyboard-row"
      row.forEach(key => {
        const btn = document.createElement("button")
        btn.className = "key"
        btn.textContent = key

        if (["⌫", "SPACE"].includes(key)) {
          btn.classList.add("wide")
        }
        if (key === "SPACE") {
          btn.classList.add("extra-wide")
        }

        btn.onclick = () => handleKeyPress(key)
        rowEl.appendChild(btn)
      })
      keyboard.appendChild(rowEl)
    })
  }

  // Ação das teclas
  function handleKeyPress(key) {
    nomeInput.focus()
    if (key === "⌫") {
      nomeInput.value = nomeInput.value.slice(0, -1)
    } else if (key === "SPACE") {
      nomeInput.value += " "
    } else {
      nomeInput.value += key
    }
  }

  // Inicializa o teclado
  createKeyboard()
})

// inserção da data no rodapé
document.getElementById('dataAtual').innerHTML = obterData()

function obterData() {
  const data = new Date()
  const options = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  }
  return data.toLocaleDateString('pt-br', options)
}