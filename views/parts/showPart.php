body {
  background: #fff;
  color: #000;
  margin: 0px;
  font-size: 18px;
}

header {
  background: #ccffcc;
  color: black;
  text-align: center;
  margin: 0px 0px 12px 0px;
  padding: 12px 0px;
}

.invert {
  background: #000;
  color: #fff;
}

header h1 {
  margin: 0px;
}

.buttons {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: space-evenly;
      -ms-flex-pack: space-evenly;
          justify-content: space-evenly;
  margin: 8px auto;
  -ms-flex-wrap: wrap;
      flex-wrap: wrap;
}

.buttons a,
input[type="submit"], a.button {
  background: #2196f3;
  color: #fff;
  text-decoration: none;
  padding: 8px;
  margin: 4px auto;
  border-radius: 4px;
  cursor: pointer;
}

.buttons a:hover,
input[type="submit"]:hover, a.button:hover {
  background: #3f51b5;
}

.buttons a.active, a.button:hover {
  background: #3f51b5;
}

a.button {
  margin-top: 10px;
  margin-bottom: 10px;
}

.center {
  margin: auto;
  text-align: center;
}

form label,
form input {
  display: inline-block;
  margin-bottom: 8px;
}

#message {
  width: -webkit-fit-content;
  width: -moz-fit-content;
  width: fit-content;
  padding: 0px 20px;
}

#message p {
  display: inline-block;
  border-bottom: 1px solid;
  padding: 0px 12px;
}

#message p {
  display: inline-block;
  border-bottom: 1px solid;
  padding: 0px 12px;
}

div#message.warning {
  background: #ff0000;
  color: #fff;
}

div#message.alert {
  background: #ffc800;
  color: #000;
}

div#message.ok {
  background: #8bc34a;
  color: #000;
}

table.th-small-pd th {
  padding-top: 8px;
  padding-bottom: 8px;
}

figure,
img {
  max-width: 100%;
}

/*text size*/
h1 {
  font-size: 36px;
}

h2 {
  font-size: 30px;
}

h3 {
  font-size: 26px;
}

h4 {
  font-size: 22px;
}

h5 {
  font-size: 18px;
}

h6 {
  font-size: 14px;
}

p {
  line-height: 1.6;
}

img {
  max-width: 100%;
}

.text-center {
  text-align: center;
}

header > p,
header > p {
  margin: 0px;
}

#site-name {
  font-size: 30px;
}

/*main container*/
#main {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
      -ms-flex-direction: row;
          flex-direction: row;
  -ms-flex-wrap: wrap;
      flex-wrap: wrap;
  -ms-flex-pack: distribute;
      justify-content: space-around;
  -webkit-box-align: stretch;
      -ms-flex-align: stretch;
          align-items: stretch;
}

/*flex items*/
.flex-item {
  -ms-flex-preferred-size: 0px;
      flex-basis: 0px;
  padding: 8px;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

aside.flex-item {
  -webkit-box-flex: 1;
      -ms-flex-positive: 1;
          flex-grow: 1;
}

#content.flex-item {
  -webkit-box-flex: 4;
      -ms-flex-positive: 4;
          flex-grow: 4;
  margin-bottom: 20px;
}

.float-r {
  float: right;
}

/*rozwijane sekcje*/
summary {
  cursor: pointer;
  outline: 0px;
}

details[open] summary ~ * {
  -webkit-animation: details-trans 0.4s cubic-bezier(0.65, 0.05, 0.36, 1);
  animation: details-trans 0.4s cubic-bezier(0.65, 0.05, 0.36, 1);
}

@-webkit-keyframes details-trans {
  0% {
    opacity: 0;
    line-height: 0.6;
  }
  100% {
    opacity: 1;
    line-height: 1.6;
  }
}

@keyframes details-trans {
  0% {
    opacity: 0;
    line-height: 0.6;
  }
  100% {
    opacity: 1;
    line-height: 1.6;
  }
}

.nomargin-r {
  margin-right: 0px;
}

/*iframe z mapa*/
.map iframe {
  width: 100%;
  height: 350px;
  overflow: hidden;
}

@media all and (max-width: 600px) {
  #main {
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
  }
  img.promo {
    width: unset;
  }
}

.jakas {
  display: none;
}

@media print {
  header,
  footer,
  aside,
  .promo,
  .menu,
  .map {
    display: none;
  }
}

table#books th {
  width: 20%;
}

table#books td,
table#books th,
table.simple-border td,
table.simple-border th {
  border: 1px solid #bbb;
}

table#books,
table.full-width {
  border-spacing: 0px;
  width: 100%;
}

#list a, .list a {
  background: #3f51b5;
  color: #fff;
  text-decoration: none;
  padding: 2px;
  margin: 2px auto;
  border-radius: 4px;
  cursor: pointer;
  display: block;
}

#list a:hover, .list a:hover {
  background: #2196f3;
}

/*START ALERTS*/
.alert {
  display: block;
  margin: 8px auto;
  max-width: 1200px;
  text-align: center;
  color: #fff;
  background-color: #000;
  border: 1px solid #000;
  position: relative;
  min-height: 16px;
}

.alert.closed {
  display: none;
  opacity: 0;
  visibility: hidden;
}

.alert.info {
  background-color: #333;
}

.alert.warning {
  background-color: #ff9800;
}

.alert.success {
  background-color: #8bc34b;
}

.alert.error {
  background-color: #fe121a;
}

.alert span.close {
  cursor: pointer;
  position: absolute;
  top: 0px;
  right: 0px;
  padding: 8px;
}

.alert span.close:hover {
  background-color: black;
}

/*END ALERTS*/
table {
  display: table;
  border-collapse: separate;
  border-spacing: 0px;
  border-color: gray;
  text-align: left;
}

table th,
table td {
  border: 1px solid gray;
}

.center > table {
  margin: auto;
}

table.book-info, table.egz-info, table.min-width {
  width: 600px;
  max-width: 90%;
}

a.button {
  text-align: center;
}

.two-column > .center {
  margin: 0px auto;
}

.two-column {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
      flex-wrap: wrap;
}

*:disabled, input:disabled {
  -webkit-filter: grayscale(1);
          filter: grayscale(1);
  cursor: not-allowed;
}

div.errorDiv {
  width: 200px;
  min-height: 20px;
}

.tippy-box[data-theme~='error'] {
  background-color: red;
  color: white;
}

.tippy-box[data-theme~='success'] {
  background-color: green;
  color: white;
}

.tippy-box {
  font-size: 16px;
}

body#register-step2 {
  background: #1a237e;
  color: #fff;
}

body#register-step2 input {
  font-size: 20px;
}

body#register-step2 label {
  font-size: 26px;
  max-width: 100%;
}

body#register-step2 input {
  width: 300px;
  max-width: 100%;
}

input[data-isvalid="false"] {
  border: 3px solid red;
  -webkit-box-shadow: 0 0 9px 4px #fff;
          box-shadow: 0 0 9px 4px #fff;
  margin: 4px 0px;
}

input[data-isvalid="true"] {
  border: 3px solid green;
  -webkit-box-shadow: 0 0 9px 4px #fff;
          box-shadow: 0 0 9px 4px #fff;
  margin: 4px 0px;
}