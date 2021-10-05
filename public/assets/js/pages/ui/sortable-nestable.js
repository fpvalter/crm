$('.dd').nestable({
    callback: function(l,e){
        // l is the main container
        // e is the element that was moved
    }
});
$('.dd').nestable({
    onDragStart: function(l,e){
        // l is the main container
        // e is the element that was moved
    }
});
$('.dd').nestable({
    onDragStart: function (l, e) {
        // get type of dragged element
        var type = $(e).data('type');
        
        // based on type of dragged element add or remove no children class
        switch (type) {
            case 'type1':
                // element of type1 can be child of type2 and type3
                l.find("[data-type=type2]").removeClass('dd-nochildren');
                l.find("[data-type=type3]").removeClass('dd-nochildren');
                break;
            case 'type2':
                // element of type2 cannot be child of type2 or type3
                l.find("[data-type=type2]").addClass('dd-nochildren');
                l.find("[data-type=type3]").addClass('dd-nochildren');
                break;
            case 'type3':
                // element of type3 cannot be child of type2 but can be child of type3
                l.find("[data-type=type2]").addClass('dd-nochildren');
                l.find("[data-type=type3]").removeClass('dd-nochildren');
                break;
            default:
                console.error("Invalid type");
        }
    }
});
$('.dd').nestable({
    beforeDragStop: function(l,e, p){
        // l is the main container
        // e is the element that was moved
        // p is the place where element was moved.
    }
});