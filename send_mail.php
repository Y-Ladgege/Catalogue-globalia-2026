<?php
// Sécurité : on n'accepte que les requêtes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Méthode non autorisée');
}

// Destinataire
$destinataire = 'bob@globaliaa.com';

// Détection du type de formulaire
$type = isset($_POST['type_formulaire']) ? $_POST['type_formulaire'] : 'inconnu';

if ($type === 'devis') {

    $entreprise = htmlspecialchars($_POST['entreprise'] ?? '');
    $contact    = htmlspecialchars($_POST['contact'] ?? '');
    $email      = htmlspecialchars($_POST['email'] ?? '');
    $telephone  = htmlspecialchars($_POST['telephone'] ?? '');
    $adresse    = htmlspecialchars($_POST['adresse'] ?? '');
    $secteur    = htmlspecialchars($_POST['secteur'] ?? '');
    $effectif   = htmlspecialchars($_POST['effectif'] ?? '');
    $pack       = htmlspecialchars($_POST['pack'] ?? '');
    $outil      = htmlspecialchars($_POST['outil'] ?? '');
    $dates      = htmlspecialchars($_POST['dates'] ?? '');
    $horaires   = htmlspecialchars($_POST['horaires'] ?? '');
    $pause      = htmlspecialchars($_POST['pause'] ?? '');
    $lieu       = htmlspecialchars($_POST['lieu'] ?? '');
    $nb         = htmlspecialchars($_POST['nbParticipants'] ?? '');
    $fpg        = isset($_POST['fpg']) ? 'Oui' : 'Non';
    $commentaires = htmlspecialchars($_POST['commentaires'] ?? '');

    $sujet = "Demande de devis — Pack $pack — $entreprise";

    $corps = "DEMANDE DE DEVIS\n";
    $corps .= str_repeat('=', 40) . "\n\n";
    $corps .= "ENTREPRISE\n";
    $corps .= "Nom : $entreprise\n";
    $corps .= "Contact : $contact\n";
    $corps .= "Email : $email\n";
    $corps .= "Téléphone : $telephone\n";
    $corps .= "Adresse : $adresse\n";
    $corps .= "Secteur : $secteur\n";
    $corps .= "Effectif : $effectif\n\n";
    $corps .= "FORMATION\n";
    $corps .= "Pack souhaité : $pack\n";
    $corps .= "Outil IA : $outil\n\n";
    $corps .= "LOGISTIQUE\n";
    $corps .= "Dates disponibles : $dates\n";
    $corps .= "Horaires : $horaires\n";
    $corps .= "Pause déjeuner : $pause\n";
    $corps .= "Lieu : $lieu\n";
    $corps .= "Nombre de participants : $nb\n\n";
    $corps .= "FINANCEMENT\n";
    $corps .= "Demande FPG : $fpg\n\n";
    $corps .= "COMMENTAIRES\n";
    $corps .= "$commentaires\n";

} elseif ($type === 'inscription') {

    $civilite     = htmlspecialchars($_POST['civilite'] ?? '');
    $nom          = htmlspecialchars($_POST['nom'] ?? '');
    $prenom       = htmlspecialchars($_POST['prenom'] ?? '');
    $email        = htmlspecialchars($_POST['email'] ?? '');
    $telephone    = htmlspecialchars($_POST['telephone'] ?? '');
    $adresse      = htmlspecialchars($_POST['adresse'] ?? '');
    $profession   = htmlspecialchars($_POST['profession'] ?? '');
    $pack         = htmlspecialchars($_POST['pack'] ?? '');
    $outil        = htmlspecialchars($_POST['outil'] ?? '');
    $disponibilites = htmlspecialchars($_POST['disponibilites'] ?? '');
    $format       = htmlspecialchars($_POST['format'] ?? '');
    $commentaires = htmlspecialchars($_POST['commentaires'] ?? '');

    $sujet = "Inscription — $pack — $civilite $nom $prenom";

    $corps = "INSCRIPTION PARTICULIER\n";
    $corps .= str_repeat('=', 40) . "\n\n";
    $corps .= "STAGIAIRE\n";
    $corps .= "Civilité : $civilite\n";
    $corps .= "Nom : $nom\n";
    $corps .= "Prénom : $prenom\n";
    $corps .= "Email : $email\n";
    $corps .= "Téléphone : $telephone\n";
    $corps .= "Adresse : $adresse\n";
    $corps .= "Profession : $profession\n\n";
    $corps .= "FORMATION\n";
    $corps .= "Formule choisie : $pack\n";
    $corps .= "Outil IA souhaité : $outil\n\n";
    $corps .= "DISPONIBILITÉS\n";
    $corps .= "Disponibilités : $disponibilites\n";
    $corps .= "Format souhaité : $format\n\n";
    $corps .= "COMMENTAIRES\n";
    $corps .= "$commentaires\n";

} else {
    http_response_code(400);
    exit('Type de formulaire inconnu');
}

// En-têtes mail
$headers  = "From: no-reply@globaliaa.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Envoi
$envoi = mail($destinataire, $sujet, $corps, $headers);

// Réponse JSON
header('Content-Type: application/json');
if ($envoi) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi']);
}
?>
