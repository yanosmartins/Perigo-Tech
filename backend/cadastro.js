const form = document.getElementById('cadastroForm');
const mensagem = document.getElementById('mensagem');

  if (senha !== confirmaSenha) {
    mensagem.textContent = 'As senhas não coincidem.';
    mensagem.style.color = 'red';
    return;
  }


  setTimeout(()=> {
    window.location.href = 'login.html';
  }, 2000);
  form.reset();
;

form.addEventListener('reset', function() {
  mensagem.textContent = '';
  mensagem.style.color = '';
});

function mascaraCPF(valor) {
  return valor
    .replace(/\D/g, '')
    .replace(/(\d{3})(\d)/, '$1.$2')
    .replace(/(\d{3})(\d)/, '$1.$2')
    .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
}

function mascaraTelCelular(valor) {
  valor = valor.replace(/\D/g, '');
  if (valor.length > 11) valor = valor.slice(0, 11);
  valor = valor.replace(/^(\d{2})(\d)/g, '($1) $2');
  valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
  return valor;
}

function mascaraTelFixo(valor) {
  valor = valor.replace(/\D/g, '');
  if (valor.length > 10) valor = valor.slice(0, 10);
  valor = valor.replace(/^(\d{2})(\d)/g, '($1) $2');
  valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
  return valor;
}

document.getElementById('cpf').addEventListener('input', function(e) {
  e.target.value = mascaraCPF(e.target.value);
});

document.getElementById('telCelular').addEventListener('input', function(e) {
  e.target.value = mascaraTelCelular(e.target.value);
});

document.getElementById('telFixo').addEventListener('input', function(e) {
  e.target.value = mascaraTelFixo(e.target.value);
});

document.getElementById('cep').addEventListener('blur', function() {
  const cep = this.value.replace(/\D/g, '');
  if (cep.length === 8) {
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
      .then(response => response.json())
      .then(data => {
        if (!data.erro) {
          document.getElementById('endereco').value = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
        } else {
          alert('CEP não encontrado.');
          document.getElementById('endereco').value = '';
        }
      })
      .catch(() => {
        alert('Erro ao buscar o CEP.');
      });
  } else {
    alert('Por favor, insira um CEP válido de 8 dígitos.');
  }
});
