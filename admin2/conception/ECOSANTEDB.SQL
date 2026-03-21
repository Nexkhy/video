drop database if exists ecosantedb;

create database ecosantedb character set utf8;
use ecosantedb;


# -----------------------------------------------------------------------------
#       table : notification
# -----------------------------------------------------------------------------

create table if not exists notification (
  idnotification integer(2) not null auto_increment ,
  iduser integer(2) not null  ,
  objet varchar(128) null  ,
  description text null  ,
  statut varchar(128) null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idnotification) 
) 
comment = "";



# -----------------------------------------------------------------------------
#       table : paiement
# -----------------------------------------------------------------------------

create table if not exists paiement (
  idpaiement integer(2) not null auto_increment ,
  idconsultation integer(2) not null  ,
  idmode integer(2) not null  ,
  reference varchar(128) null  ,
  motif text null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idpaiement) 
) 
comment = "";



# -----------------------------------------------------------------------------
#       table : user
# -----------------------------------------------------------------------------

create table if not exists user (
  iduser integer(2) not null auto_increment ,
  idspecialite integer(2) null  ,
  nom varchar(128) null  ,
  prenom varchar(128) null  ,
  sexe varchar(128) null  ,
  adresse text null  ,
  telephone varchar(128) null  ,
  email varchar(128) null  ,
  password varchar(128) null  ,
  role enum('admin', 'medecin', 'patient') not null ,
  photo text null  ,
  statut varchar(128) null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (iduser) 
) 
comment = "";

insert into user(idspecialite, nom, prenom, sexe, adresse, telephone, email, password, role, photo, statut)
values
(null, "Admin", "Admin", "M", "IPH Hotellerie, NDONGBONG", "693909121", "admin@yahoo.com", "$2y$10$nLXOx6AS247CCYNhZ2TjUuE7CbuD9NzsOWa1k6lxfzPy.ftDkIlva", "admin", null, "offline");





# -----------------------------------------------------------------------------
#       table : rdv
# -----------------------------------------------------------------------------

create table if not exists rdv (
  idrdv integer(2) not null auto_increment ,
  iduser integer(2) not null  ,
  idmedecin integer(2) not null  ,
  motif text null  ,
  duree real null  ,
  date_rdv datetime null  ,
  statut varchar(128) null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idrdv) 
) 
comment = "";


# -----------------------------------------------------------------------------
#       table : medicament
# -----------------------------------------------------------------------------

create table if not exists medicament (
  idmedicament integer(2) not null auto_increment ,
  idsuivie integer(2) not null  ,
  intitule varchar(128) null  ,
  description text null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idmedicament) 
) 
comment = "";



# -----------------------------------------------------------------------------
#       table : avis
# -----------------------------------------------------------------------------

create table if not exists avis (
  idavis integer(2) not null auto_increment ,
  idconsultation integer(2) not null  ,
  note real null  ,
  message text null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idavis) 
) 
comment = "";



# -----------------------------------------------------------------------------
#       table : examen
# -----------------------------------------------------------------------------

create table if not exists examen (
  idexamen integer(2) not null auto_increment ,
  idsuivie integer(2) not null  ,
  intitule varchar(128) null  ,
  description text null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idexamen) 
) 
comment = "";



# -----------------------------------------------------------------------------
#       table : specialite
# -----------------------------------------------------------------------------

create table if not exists specialite (
  idspecialite integer(2) not null auto_increment ,
  intitule varchar(128) null ,
  montant_consultation real null ,
  taux real null ,
  created_at datetime null ,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idspecialite) 
) 
comment = "";

insert into specialite (intitule, montant_consultation, taux)
values
("Cardiologue", 5000, 10),
("Médecin généraliste", 2000, 5),
("Dentiste", 4000, 10),
("Génycologue", 5000, 10),
("Naturopathe", 4000, 8),
("Dermatologue", 3000, 10),
("Ophtamologue", 3500, 10),
("ORL", 3200, 10),
("Pneumologue", 3400, 10);




# -----------------------------------------------------------------------------
#       table : suivie
# -----------------------------------------------------------------------------

create table if not exists suivie (
  idsuivie integer(2) not null auto_increment ,
  idconsultation integer(2) not null  ,
  observation text null  ,
  recommendations text null  ,
  nature_rdv varchar(128) null  ,
  date_suivie datetime null  ,
  date_prochain_rdv datetime null  ,
  document text null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idsuivie) 
)
comment = "";



# -----------------------------------------------------------------------------
#       table : mode
# -----------------------------------------------------------------------------

create table if not exists mode (
  idmode integer(2) not null auto_increment ,
  intitule varchar(128) null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idmode) 
) 
comment = "";

insert into mode(intitule)
values
('Espèces'),
('Orange Money'),
('MTN Mobile Money'),
('Carte VISA');


# -----------------------------------------------------------------------------
#       table : consultation
# -----------------------------------------------------------------------------

create table if not exists consultation (
  idconsultation integer(2) not null auto_increment ,
  iduser integer(2) not null  ,
  idmedecin integer(2) not null  ,
  reference varchar(128) null  ,
  poids real null  ,
  taille real null  ,
  tension varchar(128) null  ,
  montant real null  ,
  taux real null  ,
  statut varchar(128) null  ,
  date_consultation datetime null  ,
  document text null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idconsultation) 
) 
comment = "";



# -----------------------------------------------------------------------------
#       table : planning
# -----------------------------------------------------------------------------

create table if not exists planning (
  idplanning integer(2) not null auto_increment ,
  iduser integer(2) not null  ,
  jour varchar(128) null  ,
  heure_debut time null  ,
  heure_fin time null  ,
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp ,
  primary key (idplanning) 
)
comment = "";





# -----------------------------------------------------------------------------
#       creation des references de table
# -----------------------------------------------------------------------------


alter table notification 
  add foreign key fk_notification_user (iduser)
      references user (iduser) ;


alter table paiement 
  add foreign key fk_paiement_consultation (idconsultation)
      references consultation (idconsultation) ;


alter table paiement 
  add foreign key fk_paiement_mode (idmode)
      references mode (idmode) ;


alter table user 
  add foreign key fk_user_specialite (idspecialite)
      references specialite (idspecialite) ;


alter table rdv 
  add foreign key fk_rdv_user (iduser)
      references user (iduser) ;


alter table rdv 
  add foreign key fk_rdv_user2 (idmedecin)
      references user (iduser) ;


alter table medicament 
  add foreign key fk_medicament_suivie (idsuivie)
      references suivie (idsuivie) ;


alter table avis 
  add foreign key fk_avis_consultation (idconsultation)
      references consultation (idconsultation) ;


alter table examen 
  add foreign key fk_examen_suivie (idsuivie)
      references suivie (idsuivie) ;


alter table suivie 
  add foreign key fk_suivie_consultation (idconsultation)
      references consultation (idconsultation) ;


alter table consultation 
  add foreign key fk_consultation_user (iduser)
      references user (iduser) ;


alter table consultation 
  add foreign key fk_consultation_user2 (idmedecin)
      references user (iduser) ;


alter table planning 
  add foreign key fk_planning_user (iduser)
      references user (iduser) ;

