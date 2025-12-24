<?php
$this->title = 'CERI Car by Chiheb';

use yii\helpers\Url;
use yii\helpers\Html;
?>

<section class="hero" id="accueil">
    <div class="hero-content" id="hero-default-content">
        <div class="hero-text" >
            <span class="hero-badge">Trajets dans toute la France</span>
            <h1>Partage la route,<br>Partage les frais,<br>Partage le moment.</h1>
            <p>La façon la plus simple, économique et conviviale de voyager. Rejoins la communauté CERI Car dès aujourd'hui.</p>
        </div>
        <div class="hero-visual">
            <img src="<?=Url::to('@web/images/hero-img.jpg') ?>" alt="Voyage"">
        </div>
    </div>

    <div class="search-layout-ajax" id="hero-ajax-results" style="display: none;"></div>
    <div class="reservation-layout" id="reservation-ajax-container" style="display: none;"></div>
    <div class="voyage-layout" id="voyage-ajax-container" style="display: none;"></div>

    <div class="search-container-wrapper">
        <form id="search-form" class="search-bar" role="search">
            <div class="search-group">
                <img src="https://img.icons8.com/ios/50/sent--v1.png" alt="Départ" class="input-icon">
                <div class="input-stack">
                    <?=Html::input(
                            'text',
                            'depart',
                            null,
                            [
                                    'class' => 'input',
                                    'placeholder' => 'Départ',
                                    'required' => true,
                            ]

                    ) ?>
                    <label for="depart">D'où partez-vous ?</label>
                </div>
            </div>

            <div class="divider"></div>

            <div class="search-group">
                <img src="https://img.icons8.com/ios/50/address--v1.png" alt="Arrivée" class="input-icon">
                <div class="input-stack">
                    <?=Html::input(
                            'text',
                            'arrivee',
                            null,
                            [
                                    'class' => 'input',
                                    'placeholder' => 'Arrivée',
                                    'required' => true,
                            ]

                    ) ?>
                    <label for="arrivee">Où allez-vous ?</label>
                </div>
            </div>

            <div class="divider"></div>

            <div class="search-group">
                <img src="https://img.icons8.com/parakeet-line/48/person-male.png" alt="Passagers" class="input-icon">
                <div class="input-stack">
                    <?=Html::input(
                            'number',
                            'places',
                            1,
                            [
                                    'class' => 'input',
                                    'placeholder' => 'Passagers',
                                    'required' => true,
                                    'min' => 1,
                            ]

                    ) ?>
                    <label for="places">Voyageurs</label>
                </div>
            </div>

            <button type="submit" class="search-btn">
                <span class="search-btn-text">Rechercher</span>
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAABvklEQVR4nO2WS0oDQRCGBx/Z+NgpeAX1DupaFyqaKwTF9ymC19DoUQRx4wNUYtyGkGT+v2dmoauSijUwK7U7IQhaUDAw/dfXVFdVdxT9228xESmRLAO4APBEMlPXbwA1/adrBgoFsEmyQVK+cgAvADb6BorICMnTQvBb59xBkiTzzWZzQr3b7S7EcXxI8q6wrqraYDANCuCNZOWrYLbJHVvbg/eTXtFAcRwveeiWcziA9ZBCatjOK76bJrlr4LqIjPsIy/mZhpyViIySvDf41o+FAC4NvO8LLcQ4MvC5j+hZRVq9oWCtdgM//VhEMlVRq9WaDAW32+0py1o6VHCn05n2BmMwqV7MK9sHXFORTqRQMIATA5+FtNNdH+30YDG2fYQlHfgm3PEFk9wzbUNExrzEADbykalj0EO3AuBdtc65tSjESFYLl8SupvCb9O7lUACtNE1ng8DyeeP04Ob3OpF0OGirqWv1AjgunGkPmq8PhqvpLaNt8d1DgOSrc25VYfms7hsuIuM68HX2Ani0IaNPn7q2jFZvsZAGCve1JElm8peJbjbLsrnoT8DTQtoBXA8NXIDfALgaKvjfIrMPDB/TSpPDn+oAAAAASUVORK5CYII=" alt="Search" class="search-icon-img">
            </button>

        </form>
    </div>
</section>

<div class="auth-main" id="auth-container" style="display: none;"></div>
<div class="auth-main" id="profile-ajax-container" style="display: none;"></div>
<div class="auth-main" id="create-ajax-container" style="display: none;"></div>


<section class="popular-ville" id="villes">
    <div class="section-header">
        <h2>Destinations Populaires</h2>
        <p>Les trajets préférés de la communauté.</p>
    </div>
    <div class="ville-grid">
        <article class="ville-card large" style="background-image: url('<?= Url::to('@web/images/paris.jpg') ?>');">
            <div class="card-overlay">
                <h3>Paris</h3>
                <button class="glass-btn">Y aller</button>
            </div>
        </article>

        <article class="ville-card" style="background-image: url('<?= Url::to('@web/images/marseille.jpg') ?>');">
            <div class="card-overlay"><h3>Marseille</h3><button class="glass-btn">→</button></div>
        </article>
        <article class="ville-card" style="background-image: url('<?= Url::to('@web/images/lyon.jpg') ?>');">
            <div class="card-overlay"><h3>Lyon</h3><button class="glass-btn">→</button></div>
        </article>
        <article class="ville-card wide" style="background-image: url('<?= Url::to('@web/images/lille.jpg') ?>');">
            <div class="card-overlay"><h3>Lille</h3><button class="glass-btn">Découvrir</button></div>
        </article>
    </div>
</section>

<section class="how-it-works" id="concept">
    <div class="section-header">
        <h2>Simple comme bonjour</h2>
    </div>
    <div class="steps-container">
        <div class="step-card">
            <div class="step-icon">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEgAAABICAYAAABV7bNHAAAACXBIWXMAAAsTAAALEwEAmpwYAAADAUlEQVR4nO2bzWtTQRDAt4iIijcPflS8CCIlmX2Ngv+AUG0ykxYDevEiFrX17D+hBw9SIp4EL2/maZFaz4IX8aAnvwp+HPTgSduKh9pGNlVbSEnbZF9e3sv8YOBBcsj+MrO7b9g1RlEURVGUFhigh4egJBNA/ASI31iSBRfuGVBmAHk8NxL1m14DhsODFrkKxIuWpNY0UJYsSRiMymHTCwQYoSWe21BMQ/BcnqRkskxA0bW/GbFFOavZ5ErSZBFb5tOA8rtlOWskuSw0mZtzqJWyWj+A5EdhJNpvsgIg3/UlZzWTuGoys5Sjh9JqyCJedJlpMjExk+fs+R/hVZN2AGUmPkE8bdIOEL+PT5C8NWnHoszHJghl3qQdG1/21MOkHauCmqOCNsDnDnq9HbVJOxb5XWyCkF+btAO6D2qO6wrGJShAvmzSTm4k6t9U57BX38UcluRODBP0pMkKAU4d8NoPQvl+4ky4z2SJoBQN+eoo5stcNFkESjLRdk8aedxkmXyZi26D10pZAUbDphcoFO/vBZJbm1nd6t9BrmaqB72lZn5ZrgDyY7crrrdGUObrz8TT9c+yspQriqIoiqIoSssEyMct8U2L/LGFl9UPgHwjV4wGTZYoFB/tAuRLgPzKW8MM5aUluXiyEu40aaUwVt0OZRkD5K++u4lr3vC/AfH1I0MzO0x6qPVZ5AqQzMYlplEUf3J/RqUSbjPdDJR4AEhedErMOqX3PCg/OGa6j1pfvZyIfyYm5182kfxyZdc12QQrBzSfJS2mURQ/TbzJBhRaIPmctIwmkr64rUUicixGZ7uhpDYRC/kSj3ZUToDhuThOrsaWSe63YnihI3Jsmc+nSU5HJVlf1wkSlBTbNQag0MZ6ILNjwXNBifNe5eRP3dvtjtwmPzhPmUQyexSn9ngTBCSTSQ/KuyTk294E2ZWrkrWMxYJPQbUshgqiTgnCNo6sdGugLHkTBD67gV0SbkzeBOWK0eCKJF5OemDtBy+7seSRA2+CFEVRFEVRFNNz/AHeJ0WoB+xIsQAAAABJRU5ErkJggg==" alt="">
            </div>
            <h3>Connectez-vous</h3>
            <p>Créez votre profil en quelques secondes.</p>
        </div>
        <div class="step-card">
            <div class="step-icon">
                <img src="data:image/png;base64,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" alt="">
            </div>
            <h3>Recherchez</h3>
            <p>Trouvez le trajet idéal au meilleur prix.</p>
        </div>
        <div class="step-card">
            <div class="step-icon">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAFR0lEQVR4nO2cTYgcRRTHy4AfqOAXeFBR0GgkMFOvHVeNglEwIOz2q0lgDxrF2yIYRdG4Hsyu4iEBvy4KRg+CoAn93qxhE4IYL5KgaNQoOQlGD8aDHwQ0iZoEd+T1zkpYp3Z7dj6qu/N+8NjDzlT/37+ru15VV48xiqIoiqIoiqIoiqIoSmZgmK8H5AmL/BE4Pmwd/wWOmyGjpeGwdbRHtEVxstwUlQomK8DRLnA0E9rYxYNmAHlntT51gykSNuYNgHwivIHcqeF/W6RHTBEApFfDG8ZdhUV6yeQZi7wxtEnQu3jS5JEopqpFPpkDg5o96dWOTlWRIpM3AHmv/1LkP8HxK7ae3FIbTS4KrdW69y+uIt0qt7mWNp/ZH5s8ASONoQV6x/eVdXytySlS2gHSD179I40hkxfA8ZvthdIftZHkapNzonV8DSAf9VyNb5k8sHI0Occi/dbWaOQJUxCso+c8vfrI8nt3nxtan4GYnKcnnByqT11mCkJl+N1LvLV/TC4PdfP29r2Zpk3BAOSdnly2BxVWXfPOBeD4WFtxdbrPFAxwfL+n+ji+cjS5MJgwi8n6XArrpuN4B8VkvQnF7KJR2/vze6agWMfbPBXUriCCVo4ml/oGj6rj2BSUCBvonSmubVweQBA97CuHpOQzBaU2tvVsX7kqOQ9ckExPPSP0VlNwwDMBG/iUPMIdVwDyPx4xd5mCY5Hv9tynZ2QWOTAh4Ogpj8k/mcnJZaboTE4uk1w8A/3GgekAR1+2N5p3mJIASNOeMeirAT4L9Kx0If1cG5k+f6E6tYLJigj5TpkcWKQnrKPNgPyGlFUWeTc42gdIBwHpECD9KIPrXMjIf3oVcPr/0s/OfuegtCFtpaVa2jZttq7xuEyi5NiiQbT4dEoOFvkXX561Eb7RBFx8mevV+21MD0BMD4GjF1IDHe9vGdLMWcjJ+1zqftEqmkW7Rf5i4Rzp+b4bDUjf5sCgZsiwSN8Z0zyrbyZHSDeHThJyEuJFgAX+My9sPx4IrF799nne5dAzOKzjbeJN756gOPowdFKQ10D6QKbtXRst5VHwZFy+wyK93q3J94ROAgoRNCPT9iUbvVg9qcH/hdTjSzM55jtCi4eCRVRPVnVsNDh6ObRwKFhY5Bc779HIn2Rq3NFxcLSpVp+6TioU+dvaeO7dagXzA/mEdfy0LL+aHiFtWUfjnWwf7j4X2te50Y5/zSLsprhxW9tE68mqrAKto/FemNs+DxrPanK3uchC1FIEnspwBjct1AYgT2ZJMuphT277kCJbb+w6F/GsY4FZxMmltegGwoIYXetRLh0LzNLoYg9hZc9a6FsHID8zyFw6F9iDXpC+kZV5MKTxkINhr3LpWGhGgya6eUgAeYoe5dIXo2Uk9hXp4Oj2jko8FzZ6lUtfjJ4TKCOyDBZyn5O/cvbz8OImLMHsbnPpm9EarEaDGs2lDTXaqdHNMoUa7dToZplCjXZqdLNMoUY7NbpZpui70eme57ixBpBGI8cP2jqPye54i/wsIG8Bx6/J+y2trWXJ7P7l9Mej9sq2Buv4m9b+5kOtXxs4Mi/avTh67H+fk++22pE20y0TcgxHe2b3X3OSahAtqSbeIhpTrXUeE+2Sg+TS2sedL6NNSQE1ejCo0aUx2vNOdLuwjn83JQX67QMgf5b9APSpKSnQbx8A6bHMB4h5gykp0G8f5PG6Rfp60QMgHyjyu9+58KGytnHVggdBPmCHkytNyakMwgc5o5FrPCr3n3RgQD4qGyDlMilzT56P+qAoiqIoiqIoiqIoiqIoimK64V/ZDcW9PeQ3vQAAAABJRU5ErkJggg==" alt="">
            </div>
            <h3>Réservez</h3>
            <p>Voyagez en toute sécurité et convivialité.</p>
        </div>
    </div>
</section>