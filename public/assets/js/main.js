const btnProduit = document.querySelectorAll(".btnProduit");
const panierQte = document.querySelector("#panierQte");
const sectionPanier = document.querySelector("#sectionPanier");
const inputsProduits = document.querySelectorAll(".inputsProduits");

btnProduit.forEach(function (btn, key) {
	btn.addEventListener("click", async function () {
		handleDisabled(btn);
		// let idProduit = btn.dataset.id;
		let idProduit = btn.closest("p").dataset.id;
		let quantite = btn.closest("p").querySelector("input").value;
		saveProduitToSession(idProduit, quantite);
	});
});

function handleDisabled(btn) {
	if (btn.dataset.role == "+") {
		btn.previousElementSibling.value++;
		btn.previousElementSibling.previousElementSibling.removeAttribute(
			"disabled"
		);
	} else if (btn.dataset.role == "-") {
		if (btn.nextElementSibling.value > 0) {
			btn.nextElementSibling.value--;
		}
		if (btn.nextElementSibling.value == 0) {
			btn.setAttribute("disabled", "disabled");
		}
	}
}

async function saveProduitToSession(idProduit, quantite) {
	console.log(idProduit, quantite);
	const prod = {};
	prod[idProduit] = quantite;
	const getConn = await fetch("addProduit", {
		method: "POST",
		body: JSON.stringify(prod),
	});
	const response = await getConn.json();
	// mise à jour du nombre de produits du panier dans le header
	const keysPanier = Object.keys(response);
	panierQte.textContent = keysPanier.length;
}

// async function getPanier(id) {
// 	const prod = {};
// 	prod[id] = 1;
// 	const getConn = await fetch("session.php", {
// 		method: "POST",
// 		body: JSON.stringify(prod),
// 	});
// 	const response = await getConn.json();

// 	return response;
// }

// function affichagePanier(panier) {
// 	console.log("affichage panier");
// 	sectionPanier.innerHTML = "";
// 	panierQte.textContent = Object.keys(panier).length;
// 	let total = 0;
// 	Object.values(panier).forEach((produit) => {
// 		affichageProduit(produit);
// 		total +=
// 			parseFloat(produit.produit.prixProduit) *
// 			parseInt(produit.quantite);
// 	});
// 	console.log("Total", total.toFixed(2));
// 	const totalPar = document.createElement("p");
// 	totalPar.textContent = total.toFixed(2);
// 	sectionPanier.appendChild(totalPar);
// }

// function affichageProduit(produit) {
// 	console.log(produit);
// 	const titre = document.createElement("h2");
// 	titre.textContent = produit.produit.libelleProduit;
// 	sectionPanier.appendChild(titre);
// 	const quantite = document.createElement("p");
// 	quantite.textContent = produit.quantite;
// 	sectionPanier.appendChild(quantite);
// }
