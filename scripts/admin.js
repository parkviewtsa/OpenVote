var current = 'Default';
var ballotId = Math.floor((Math.random()*10000)+1);
var voterId = Math.ceil((Math.random()*10000)+1);

numCandidates=1;

function changeSemper(action){
	if (current){
		document.getElementById(current).style.display = 'none';
	}
	document.getElementById(action).style.display = 'inline';
	current = action;
}

function dropCandidate(){

}

function addCandidate(){
	var last_element = document.getElementById('candidate'+numCandidates);
	numCandidates +=1;
	t = numCandidates;
	var candidate = document.createElement("div");
	candidate.className = 'candidate';
	candidate.id = 'candidate'+numCandidates;
	
	var center = document.createElement("center");
	
	var c_image = document.createElement("img");
	c_image.src = "img/img-001.jpg";
	c_image.className = 'candidate-img';
	
	var c_label = document.createElement("label");
	c_label.appendChild(document.createTextNode("Name: "));
	
	var c_br = document.createElement("br");
	
	var c_name = document.createElement("input");
	c_name.type="text";
	c_name.name="name"+numCandidates;
	c_name.id="name"+numCandidates;
	// c_name.onfocus = f('name'+numCandidates);
	c_name.style.marginTop = "15px";
	
	document.getElementById('candidates').value = numCandidates;
	
	center.appendChild(c_image);
	center.appendChild(c_br);
	center.appendChild(c_label);
	center.appendChild(c_name);
	candidate.appendChild(center);
	document.getElementById('ballot-creator').appendChild(candidate);
	
	
}

function addIDs(){
	document.getElementById('ballot_id').value = ballotId;
	document.getElementById('voter_id').value=voterId;
}