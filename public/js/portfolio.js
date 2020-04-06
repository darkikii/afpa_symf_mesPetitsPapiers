/*-------------------------------------------------------------------------
 * file: portfolio.js
 * author: Prenom Nom
 * desription:
 ----------------------------------------------------------------------- */
$(function(){

  /* Portfolio:
   * Montrer 'detail' (portfolio)    
   */


  // Filtrer (portfolio)    
  $('ul#filtre a').click(function() {

    $('ul#filtre li').removeClass('filtre-courant');
    $(this).parent().addClass('filtre-courant');
    
    var valeurDuFiltre = $(this).text();
    
    $('div.blocperso').hide();
    
    if (valeurDuFiltre == 'Tout') {
      $('div.blocperso').show('fast');  
    }
    else {
      $('div.blocperso').each(function() {
        if( !$(this).hasClass("image") ){
          $(this).hide('fast');  
        } else {
          $(this).show('fast');  
        }
      });  
      
    }
    
    return false;
  });
 
});
