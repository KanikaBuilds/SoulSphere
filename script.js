function submitVote(type) {
    const form = document.getElementById("voteForm");
    const formData = new FormData(form);
    formData.append("vote_type", type);

    fetch("vote.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById("voteResponse").innerText = data;
    });
}
