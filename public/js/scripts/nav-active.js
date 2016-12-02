var path = window.location.pathname;
routeGroup = path.replace('/', '').split('/')[0];
if(routeGroup == 'auth')
{
	routeGroup = path.replace('/', '').split('/')[1];
}
// if(routeGroup.indexOf('team') == 0)
// {  
//     $('#nav-teams').addClass('active');;
// }
// else if(routeGroup.indexOf('news') == 0)
// {
//     $('#nav-news').addClass('active');
// }
// else if(routeGroup.indexOf('event') == 0)
// {
//     $('#nav-events').addClass('active');
// }
// else if(routeGroup.indexOf('staff') == 0)
// {
//     $('#nav-staff').addClass('active');
// }
// else if(routeGroup.indexOf('home') == 0 || path == '/')
// {  
//     $('#nav-home').addClass('active');
// }else if(var auth = path.replace('/','').split('/')[1] == 'login')
// {
// 	$('#nav-login').addClass('active');
// }else if(auth == 'register')
// {

// }

if(path == '/')
	routeGroup = 'home';
else if(routeGroup == 'users')
	routeGroup = 'profile';

$('#nav-'+routeGroup).addClass('active');

if(routeGroup == 'profile' || routeGroup == 'notifications')
{
	$('li.dropdown').addClass('active');
}