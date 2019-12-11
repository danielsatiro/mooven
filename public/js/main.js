/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {

    $('#search_form').submit(function(e) {
        e.preventDefault();
        var value = $('#q').val();

        if (value === '') {
            return false;
        }

        $.ajax({
            type:'GET',
            url:'/repos/search',
            data:{
                "q": value
            },
            success:function(data){
                $("#result").html(data);
            },
            error:function(data){
                alert(data.responseJSON.message);
            }
         });
    });
});