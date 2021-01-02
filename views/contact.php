<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php');
showHead("Kontakt", null, "index"); ?>

<body>
    <?php
    showHeader("Kontakt");
    showButtons('contact');

    if ($message)
        showMessage($message, $messageType);

    ?>
    <div id="main">
        <main id="content" class="flex-item">
            <article>
                <h1 class="text-center">Adam Mickiewicz</h1>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. <strong>Id architecto deleniti facere ratione officia.</strong>
                    Reiciendis exercitationem ullam quibusdam repellat, sit,
                    expedita odio tempora itaque temporibus dignissimos harum quia quae quaerat!

                </p>
                <figure class="float-r nomargin-r">
                    <img src="views/img/Adam-Mickiewicz.jpg" alt="Adan Mickiewicz">
                    <figcaption>Adam Mickiewicz - obraz Walentego Wańkowicza</figcaption>
                </figure>
                <section>
                    <h2>Wykształcenie</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam laudantium nisi, dignissimos quasi quod adipisci pariatur tempora corrupti quam quas consequuntur aspernatur illo
                        vitae unde in aperiam odit ullam fugiat!</p>
                    <details>
                        <summary>Więcej informacji</summary>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa deserunt vitae omnis voluptatem quaerat delectus distinctio voluptatibus, nisi temporibus totam ullam
                            molestias
                            doloribus non provident incidunt. Impedit reprehenderit optio sit praesentium dolorum atque reiciendis laborum! Accusamus corporis laboriosam id natus delectus consequatur
                            saepe eius odio hic quisquam. Veniam, rerum officiis iure est aliquam ipsam, dolorem hic dolores odit esse, repellendus omnis voluptates! Vel sapiente cupiditate
                            repellendus
                            consectetur quo nulla non hic laborum officia rerum eaque totam ipsa doloremque, animi ad perferendis distinctio itaque necessitatibus porro iure. Praesentium voluptas
                            quasi
                            cumque eaque, suscipit nesciunt, harum numquam illo qui molestias voluptatem eveniet.</p>
                    </details>
                </section>
                <h3>Studia</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi assumenda harum tempora doloribus delectus repellat officiis, aperiam veniam animi et at cum illum quis modi, culpa
                    ratione nemo non odit minus unde nulla beatae ducimus ipsam hic! Pariatur voluptatum, error, facilis reprehenderit et minus impedit, modi tempora beatae deleniti qui.</p>
                <h2>Dzieła</h2>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum, autem? Tempora soluta ea adipisci eum a? Temporibus perspiciatis id illo:
                <ul>
                    <li>Lorem, ipsum dolor.</li>
                    <li>Explicabo, voluptatibus odit.</li>
                    <li>Numquam, minus explicabo.</li>
                    <li>Iste, voluptatum repudiandae!</li>
                    <li>Cum, fuga cumque?</li>
                    <li>Explicabo, mollitia quidem?</li>
                    <li>Aliquam, sunt dolore.</li>
                    <li>Aspernatur, dolorum dolore.</li>
                </ul>
                <section>
                    <h2>Adres</h2>
                    <address>
                        Krypta Wieszczów Narodowych na Wawelu<br>Wawel 5, 31-001 Kraków
                    </address>
                </section>
                <!--skopiowane z OpenStreetMap-->
                <div class="map"><iframe src="https://www.openstreetmap.org/export/embed.html?bbox=19.92518663406372%2C50.04940963439893%2C19.946429729461673%2C50.05906742292216&amp;layer=mapnik&amp;marker=50.054238771637074%2C19.935808181762695"></iframe>
                    <br />
                    <small>
                        <a href="https://www.openstreetmap.org/?mlat=50.0542&amp;mlon=19.9358#map=16/50.0542/19.9358" target="_blank" rel="nofollow noreferrer">Wyświetl większą
                            mapę</a>
                    </small>
                </div>
                <!--koniec: skopiowane z OpenStreetMap-->
            </article>
        </main>
    </div>


</body>

</html>