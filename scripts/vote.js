var candidates_chosen = 0;

function addVote(id){
	var candidate = document.getElementById(id);
	var input = document.getElementById('c'+(candidates_chosen+1));
	candidate.style.boxShadow="5px 5px 3px #0F0";
	input.value=id;
	candidates_chosen +=1;
}