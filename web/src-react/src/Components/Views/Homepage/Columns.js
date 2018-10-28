import React from 'react';
import ReactDOM from 'react-dom';

class Columns extends React.Component {
    render() {
        return (
            <div className="container">

                <div className="row">
                    <div className="col-md-4">
                        <h2>Suivre</h2>
                        <p>
                            Le but premier de cette application est de vous laisser l'opportunité de marquer comme "vues" les vidéos
                            de la chaine ainsi que celles à venir. Cette fonctionnalité est notamment très utile pour ceux qui ont
                            désactivé l'archivage de leur historique sur leur compte google.
                        </p>
                    </div>
                    <div className="col-md-4">
                        <h2>Rechercher</h2>
                        <p>
                            Un moteur de recherche est intégré que vous puissiez rechercher n'importe quelles vidéos à partir de son
                            titre, sa description ou ses sous-titres. Tapez un mot clé, une expression ou encore une technologie,
                            vous retrouverez tous les vidéos qui correspondent à vos critères.
                        </p>
                    </div>
                    <div className="col-md-4">
                        <h2>Annoter</h2>
                        <p>
                            Il est souvent très difficile de comprendre une vidéo sans prendre de notes. En ayant été moi-même
                            étudiant, je sais qu'on n'est pas souvent préparé à la prise de notes lors d'un "cours". Ici, vous aurez
                            tout ce dont vous avez besoin pour y parvenir si vous le souhaitez.
                        </p>
                    </div>
                </div>
            </div>
        );
    }
}

export default Columns;