function search_n()
{
let a=$('#se_n').val();

$.post('search_n.php',{a:a},
function(dane)
{
let content="<center><h1> Artykuły </h1></center>";
	
for(var i=0;i<dane[0][0];i++)
{
content=content+'<a class="nav-link" href="https://poscielecapri.pl/Jakub/Szkola/blog3/artykul/'+dane[i][1]+'">'+dane[i][2]+'</a>';
}
	
$('#lista').html(content);
});
}

function search_u()
{
let a=$('#se_u').val();

$.post('search_u.php',{a:a},
function(dane)
{

let content="<center><h1> Artykuły </h1></center>";
	
for(var i=0;i<dane[0][0];i++)
{
content=content+'<a class="nav-link" href="https://poscielecapri.pl/Jakub/Szkola/blog3/artykul/'+dane[i][1]+'">'+dane[i][2]+'</a>';
}

$('#lista').html(content);
});
}