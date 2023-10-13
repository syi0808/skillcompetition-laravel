const accordions = document.getElementsByClassName('accordion-wrapper');

[...accordions].forEach((accordion) => {
  const header = accordion.getElementsByClassName('accordion-header')[0];
  const content = accordion.getElementsByClassName('accordion-content')[0];

  header.addEventListener('click', () => {
    if (!content.style.display || content.style.display === 'none') {
      content.style.display = 'block';
    } else {
      content.style.display = 'none';
    }
  });
});
