
// page qui permet d'afficher le prix du range

const selectElement = document.querySelector('#Prix');
 
selectElement.addEventListener('change', (event) => {
    const result = document.querySelector('#respondprix');
    result.innerHTML  = selectElement.value;
});
selectElement.addEventListener('input', (event) => {
  const result = document.querySelector('#respondprix');
  result.innerHTML  = selectElement.value;
});