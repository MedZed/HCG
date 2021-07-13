 <!-- ... existing HTML ... -->
 <div id="like_button_container"></div>
 <!-- ... existing HTML ... -->

 <!-- Load React. -->
 <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
 <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>


 <!-- Load our React component. -->
 <script>
     'use strict';
     const e = React.createElement;
     class LikeButton extends React.Component {
         constructor(props) {
             super(props);
             this.state = {
                 liked: false
             };
         }

         render() {
             if (this.state.liked) {
                 return e(
                 'button', {
                     onClick: () => this.setState({
                         liked: false
                     })
                 },
                 'unlike'
             );
             }

             return e(
                 'button', {
                     onClick: () => this.setState({
                         liked: true
                     })
                 },
                 'Like'
             );
         }
     }
     const domContainer = document.querySelector('#like_button_container');
     ReactDOM.render(e(LikeButton), domContainer);
 </script>

 </body>