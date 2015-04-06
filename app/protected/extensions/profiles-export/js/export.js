$(function(){
   $('.toExport').change(function(){
       var id = $(this).val();
       var checked = $(this).prop('checked');
       var list = $.cookie('toExport');

       if( list == null ) {
           list = [];
       } else {
           list = list.split(',');
       }

       if( checked ) {
           list.push(id);
       } else {
           for (var key in list) {
               console.log(key, list[key]);
               if (list[key] == id) {
                   list.splice(key, 1);
               }
           }
       }

       if(list.length) {
           $('#export-button').show();
           $('#reset-button').show();
       } else {
           $('#export-button').hide();
           $('#reset-button').hide();
       }
       $.cookie('toExport', list, {expires: 365, path: '/'});
   });

    $('#reset-button').click(function(e){
        e.preventDefault();

        if( !confirm('Ви впевнені?') ) return;

        $.cookie('toExport', '', {expires: 365, path: '/'});
        $('#export-button').hide();
        $('#reset-button').hide();
    });
});