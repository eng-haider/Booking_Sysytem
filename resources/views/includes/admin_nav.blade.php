
<div id="app">

<template>
  <v-app id="">
    <v-navigation-drawer
      v-model="drawer"
      fixed
      right
      app
    >
      <v-list dense style=" font-family: 'DroidArabicKufiRegular'; ">
        <v-list-tile   @click="" >
          <v-list-tile-action>
            <v-icon>home</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
              <v-list-tile-title>ألرئسية</v-list-tile-title>    

          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile @click="" to="/users">         
          <v-list-tile-action>
            <v-icon>contact_mail</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>ألمستخدمون</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>



       
        <v-list-tile @click="" to="/cars">         
          <v-list-tile-action>
            <v-icon>contact_mail</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>ألمركبات</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>


        <v-list-tile @click="" to="/tickets">         
          <v-list-tile-action>
            <v-icon>contact_mail</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>ألرحلات</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>


        <v-list-tile @click="" to="/orders">         
          <v-list-tile-action>
            <v-icon>contact_mail</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>ألطلبات</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>





      </v-list>


    </v-navigation-drawer>
    <v-toolbar color="cyan" dark fixed app>
      <v-spacer></v-spacer>
      <v-toolbar-title>Application</v-toolbar-title>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
    </v-toolbar>
    <v-content>

   <span>
      <router-view > </router-view>
   </span>

  
    </v-content>
    <v-footer color="cyan" app>
      <v-spacer></v-spacer>
      <span class="white--text">&copy; 2018</span>
    </v-footer>
  </v-app>
</template>


</div>
