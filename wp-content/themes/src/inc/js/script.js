toCapitalize = function(text = '') {
          var tokens = text.split(" ").filter(function(t) {return t != ""; }),
              res = [],
              i,
              len,
              component;
          for (i = 0, len = tokens.length; i < len; i++) {
              component = tokens[i];
              res.push(component.substring(0, 1).toUpperCase());
              res.push(component.substring(1));
              res.push(" "); // put space back in
          }
    return res.join("")
};


function slugify(text){
  return text.toString().toLowerCase()
    .replace(/\s+/g, '_')           // Replace spaces with -
    .replace(/[^\u0100-\uFFFF\w\-]/g,'_') // Remove all non-word chars ( fix for UTF-8 chars )
    .replace(/\-\-+/g, '_')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '')            // Trim - from end of text
    .replace(/-+/g, '_');            // Trim - from end of text
}



/*Shortcuts*/

shortcut.add("Shift+N",function() {
	window.location.href = home_page.new_billing;
});
shortcut.add("Shift+E",function() {
	jQuery('#add_new_price_range').click();
});
shortcut.add("Shift+T",function() {
	var win = window.open(home_page.new_billing, '_blank');
  	win.focus();
});
shortcut.add("Shift+V",function() {
	window.location.href = home_page.billing_list;
});

shortcut.add("Shift+C",function() {
  jQuery('.popup-add-customer').click();
});
