
function Home() {
	var self = this;

	this.http = new XMLHttpRequest(),
	this.url = `${document.getElementById('bUrl').value}back/controller.php`,

	this.init = function() {

	},
	this.isEmail =  function ( email ) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,5})+$/;
		return regex.test( email );
	},
	this.post = function(data, action) {
		return new Promise((resolve, reject) => {
			self.http.open('POST', self.url);
			self.http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			self.http.onreadystatechange = function() {

				if (self.http.readyState !== 4) return;
				if (self.http.status === 200) {
					resolve(self.http.responseText)
				}
			}

			self.http.send(`action=${action}&data=${JSON.stringify(data)}`);
		})
	},
	this.sendEmail = function() {
		var email = document.getElementById('email').value;
		if(self.isEmail(email)) {
			self.post(email, 'check_mail')
			.then(res => {
				res = JSON.parse(res);
				if(res.error) {
					document.getElementById('info').innerHTML = res.error;
				}else {
					var href = document.createElement('a');

					href.setAttribute('href', `http://localhost/Task/front/index2.php?token=${res.token}`)
					href.innerHTML = 'To registration';

					document.getElementById('form').appendChild(href);
				}
			})
		}else {
			document.getElementById('info').innerHTML = 'Invalid Email';
		}
	},
	this.sendInfo = function() {
		var name    = document.getElementById('name'),
			surname = document.getElementById('surname');

		if(name && surname) {

			self.post({
					name: name.value,
					surname: surname.value,
					token: location.search.split('=')[1]
				}, 'add_info')
			.then(res => {
				res = JSON.parse(res);
				if(res.error) {
					document.getElementById('info').innerHTML = res.error;
				}else {
					document.getElementById('info').innerHTML = res.message;
					name.value = '';
					surname.value = '';
				}
			})
		}else {
			document.getElementById('info').innerHTML = 'Empty data';
		}
	},
	this.bindEvent = function() {
		var events = {
			sendEmail: document.getElementById('addEmail'),
			sendInfo: document.getElementById('sendInfo')
		}

		for(el in events) {
			if(events[el]) {
				events[el].key = el;
				events[el].addEventListener('click', e => {
					self[e.target.key].call()
				})
			}
		}

	}
}
document.addEventListener("DOMContentLoaded", function() {
	const home = new Home();
	home.bindEvent();
}); 