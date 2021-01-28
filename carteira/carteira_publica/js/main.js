const checkbox = document.querySelector('#checkbox')
let theme = localStorage.getItem('@theme')

const themeLight = () => {
  checkbox.checked = false
  document.body.classList.add('light')
  document.body.classList.remove('dark')
  localStorage.setItem('@theme', 'light')
}

const themeDark = () => {
  checkbox.checked = true
  document.body.classList.add('dark')
  document.body.classList.remove('light')
  localStorage.setItem('@theme', 'dark')
}

if(theme === 'light') {
  themeLight();
} else if(theme === 'dark') {
  themeDark()
}

checkbox.addEventListener('change', () => {
  //encontra o tema no corpo
  theme = localStorage.getItem('@theme')
  if(theme === 'light' || theme === null){
    localStorage.setItem('@theme', 'dark')
  } else {
    localStorage.setItem('@theme', 'light')
  }
  document.body.classList.toggle('dark')
  console.log('func')
})

// EMOJI
const imgEmogi = document.querySelector('.emoji')

const emojis = [' 😁', ' 🤑', ' 🙂', ' 🤭', ' 🧐', ' 😮', ' 😝', ' 😜', ' 😛']

const emoji = () =>{
  const indice = Math.floor(Math.random() * emojis.length);
  return emojis[indice] 
}

imgEmogi.innerHTML = emoji()