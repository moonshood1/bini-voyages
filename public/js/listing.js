$("#add_image").click(function () {
  // Je recupere les numeros des futurs champs a creer
  const index = +$("#widgets-counter").val();

  // Je recupere le prototype des entrées
  const tmpl = $("#listing_images")
    .data("prototype")
    .replace(/__name__/g, index);

  // J'injecte ce code au sein de la div
  $("#listing_images").append(tmpl);

  $("#widgets-counter").val(index + 1);

  // Je gere le bouton supprimer
  handleDeleteButtons();
});
// Creation d'une fonction pour pouvoir supprimer les div des images au cas ou on les veut pas
function handleDeleteButtons() {
  // Tous buttons qui ont comme attribut data-action quelque chose qui contient delet
  $('button[data-action="delete"]').click(function () {
    const target = this.dataset.target;
    $(target).remove();
  });
}

function updateCounter() {
  const count = +$("#listing_images div.form-group").length;

  $("#widgets-counter").val(count);
}

updateCounter();
handleDeleteButtons();
