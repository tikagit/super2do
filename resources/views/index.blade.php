<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Super Todo< App</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="{{ asset('css/base.css') }}">
		<link rel="stylesheet" href="css/index.css">
		<!-- CSS overrides - remove if you don't need it -->
		<link rel="stylesheet" href="css/app.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	</head>
	<body>
		<section class="todoapp">
			<header class="header" id="formdata">
				<h1>Super2Do</h1>
				<input class="new-todo" placeholder="What needs to be done?" id="task" onkeydown="task(this)" autofocus>
				<section class="main">
				<input id="toggle-all" class="toggle-all" type="checkbox" onclick="mark(this)">
				<label for="toggle-all">Mark all as complete</label>
					<ul class="todo-list">
						<div id="completed">
							
						</div>
					</ul>
				</section>
			</header>
			<footer class="footer">
				<!-- This should be `0 items left` by default -->
				<span class="todo-count"><strong>0</strong> item left</span>
				<!-- Remove this if you don't implement routing -->
				<ul class="filters">
					<li>
						<a class="selected" href="#/" onclick="getData()">All</a>
					</li>
					<li>
						<a href="#/active" onclick="active()">Active</a>
					</li>
					<li>
						<a href="#/completed" onclick="completed()">Completed</a>
					</li>
				</ul>
				<!-- Hidden if no completed items are left ↓ -->
				<button class="clear-completed">Clear completed</button>
			</footer>
		</section>
		<!-- Scripts here. Don't remove ↓ -->
		<script src="js/app.js"></script>
	</body>
</html>
<script>
// $(document).ready(function () {
	function task(nilai) {
		if(event.key === 'Enter') {
        	// alert(nilai.value);
        	$.ajax({
			    type: "POST",
			    url: '/simpan-data',
			    data: { somefield: "Some field value", _token: '{{csrf_token()}}', nilai: nilai.value },
			    success: function (data) {
			    	getData();
			    	var input = document.getElementById('task');
			    	input.value = '';
			    },
			    error: function (data, textStatus, errorThrown) {
			        console.log(data);
			    },
			});
    	}
	}


	getData();

	function getData() {
            $.ajax({
                url: "{{ url('task/getData') }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    var isi = ``;
                    for (var i = 0; i < data.data.length; i++) {
                        var desc = '';
                        var datas = ``;
                        if (data.data[i].status == 'aktif') {
                            desc += 'checked';
                            datas += `<s>` + data.data[i].status + `</s>`;
                            isi += `<li class="completed">
									<div class="view">
										<input class="toggle" type="checkbox" checked onClick="ubah(`+ data.data[i].id +`)">
										<label>` + data.data[i].task + `</label>
										<button class="destroy" onClick="hapus(`+ data.data[i].id +`)"></button>
									</div>
									<input class="edit" value="Create a Todo template">
								</li>`;
                        } else {
                            datas += data.data[i].status;
                            isi += `<li>
									<div class="view">
										<input class="toggle" type="checkbox" onClick="ubah(`+ data.data[i].id +`)">
										<label>` + data.data[i].task + `</label>
										<button class="destroy" onClick="hapus(`+ data.data[i].id +`)"></button>
									</div>
									<input class="edit" value="Create a Todo template">
								</li>`;
                        }
                    }
                    $('#completed').html(isi);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                }
            });
    }

    function hapus(id) {
    	console.log(id);
        	$.ajax({
			    type: "POST",
			    url: 'task/deleteData',
			    data: { id: id, _token: '{{csrf_token()}}' },
			    success: function (data) {
			    	getData();
			    },
			    error: function (data, textStatus, errorThrown) {
				}
			});
	}

	function ubah(id) {
    	console.log(id);
        	$.ajax({
			    type: "POST",
			    url: 'task/ubahData',
			    data: { id: id, _token: '{{csrf_token()}}' },
			    success: function (data) {
			    	getData();
			    },
			    error: function (data, textStatus, errorThrown) {
				}
			});
	}

	function active() {
            $.ajax({
                url: "{{ url('task/aktifData') }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    var isi = ``;
                    for (var i = 0; i < data.data.length; i++) {
                        var desc = '';
                        var datas = ``;
                        if (data.data[i].status == 'aktif') {
                            desc += 'checked';
                            datas += `<s>` + data.data[i].status + `</s>`;
                            isi += `<li class="completed">
									<div class="view">
										<input class="toggle" type="checkbox" checked onClick="ubah(`+ data.data[i].id +`)">
										<label>` + data.data[i].task + `</label>
										<button class="destroy" onClick="hapus(`+ data.data[i].id +`)"></button>
									</div>
									<input class="edit" value="Create a Todo template">
								</li>`;
                        }
                    }
                    $('#completed').html(isi);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                }
            });
    }

    function completed() {
            $.ajax({
                url: "{{ url('task/completedData') }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    var isi = ``;
                    for (var i = 0; i < data.data.length; i++) {
                        var desc = '';
                        var datas = ``;
                        if (data.data[i].status == 'complete') {
                            isi += `<li>
									<div class="view">
										<input class="toggle" type="checkbox" onClick="ubah(`+ data.data[i].id +`)">
										<label>` + data.data[i].task + `</label>
										<button class="destroy" onClick="hapus(`+ data.data[i].id +`)"></button>
									</div>
									<input class="edit" value="Create a Todo template">
								</li>`;
                        }
                    }
                    $('#completed').html(isi);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                }
            });
    }


    function mark(elem) {
    	// console.log('www', elem.checked)
    	if (elem.checked === true) {
    		console.log('kkk')
    		$.ajax({
			    type: "POST",
			    url: 'task/markDataTrue',
			    data: { _token: '{{csrf_token()}}' },
			    success: function (data) {
			    	getData();
			    },
			    error: function (data, textStatus, errorThrown) {
				}
			});
    	} else if (elem.checked === false) {
    		console.log('llll')
    		$.ajax({
			    type: "POST",
			    url: 'task/markDataFalse',
			    data: { _token: '{{csrf_token()}}' },
			    success: function (data) {
			    	getData();
			    },
			    error: function (data, textStatus, errorThrown) {
				}
			});
    	}
        	
	}
	
</script>
