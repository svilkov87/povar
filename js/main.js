// выпадающее меню
$(document).ready(function(){
  $(".fa-angle-down").click(function(){
    $(".menu_open").fadeToggle(500);
    // $(".fa-angle-down").css("transform", "rotate(180deg)");
  });

// выпадающий поиск

  $("#stuff_menu_search").click(function(e){
    e.preventDefault();
    $(".stuff_menu_search_field").slideToggle(100);
        // $(".stuff_menu_search_field").css("display" , "block");
  });


  // навигация при скроллинге

  $(window).scroll(function() {
    if ($(this).scrollTop() > 80){
      $('.nav').addClass("nav_fixed"),
        $('.nav').fadeIn(2000);
    }
    else{
      $('.nav').removeClass("nav_fixed");
    }
  });


  // показать кнопку наверх
  $(window).scroll(function() {
    if ($(this).scrollTop() > 350){
      $('#top').fadeIn(100);
    }
    else{
      $('#top').fadeOut(100);
    }
  });

  //Кнопка "Наверх"
  //Документация:
  //http://api.jquery.com/scrolltop/
  //http://api.jquery.com/animate/
  $("#top").click(function () {
    $("body, html").animate({
      scrollTop: 0
    }, 800);
    return false;
  });



  //Плавный скролл до блока textarea по клику на .send_name
  //Документация: https://github.com/flesler/jquery.scrollTo
  $(".send_name").click(function() {
    $.scrollTo($("#answer"), 600, {
      offset: -350
    });
  });

// ответ юзеру(перемещение информации в поля отправки)
  $('.send_name').click(function(e){
    e.preventDefault();
    $('#answer').val($(this).siblings('.p').html().trim() + ',')
    $('.fa-times').css("display", "block");
    $('#answer_input').val($(this).siblings('#hidden_id').html().trim());
    $('#answer_input_to_user').val($(this).siblings('#hidden_id_to_user').html().trim());
    $('#answer_to_comment').val($(this).siblings('#hidden_text_to_comment').html().trim());
    $('#answer_input_image').val($(this).siblings('#hidden_image_to_comment').html().trim());
  });

  
  //удаление данных
  $('.span_delete_items').on('click', function() {
    $('li.span_delete_username').html('');
    $('.fa-times').css("display", "none");
    $('#answer').val('');
    $('#answer_to_comment').val('');
    $('#answer_input_to_user').val('');
    $('#answer_input').val('');

  });

  //вставка в поле для post отправки картинки
  // $('#answer').on('click', function(){
  //   $('#answer_input_image').val($('#hidden_image_to_comment').text());
  // });

  //вставка под полем texarea ник, кому отпраляется мессейдж
  // $('#answer').on('click', function(){
  //   $('.span_delete_username').val($('.p').text());
  // });


});

// появление имени пользователя в нав панели при авторизации
$(document).ready(function(){
  function func() {
    $(".session_name").fadeOut(3000);
    //alert( 'click' );
  };
  setTimeout(func, 3000);
});
