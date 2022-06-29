<v-navigation-drawer  v-model="drawer" app>
    <v-card color="white" tile  elevation="0">
        <v-card-title class="text-center">
            <v-avatar size="96" class="mx-auto">
                <v-img src="/images/profile.jpg"></v-img>
            </v-avatar>
        </v-card-title>
        <v-card-text class="text-center">
            <p class="caption text-center ma-0 font-weight-bold" >Yecid Alberto Tovar Tovar</p>
            <p class="caption text-center ma-0" >(+57) 321 414 0263</p>

        </v-card-text>
    </v-card>

    
    <v-list dense shaped >
        <template v-for="item in items_menu">
            
            <v-list-item active-class="primary--text" :to="item.url" :key="item.title" >
                <v-list-item-icon>
                    <v-icon>@{{ item.icon }}</v-icon>
                </v-list-item-icon>
    
                <v-list-item-content>
                    <v-list-item-title>@{{ item.title }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>

        
    </v-list>

    <template v-slot:append>
        <v-list  dark color="primary" dense shaped class="d-flex" style="align-items: end;">
           <v-list-item
              to="/yecid-tovar"
              link
              >
              <v-list-item-icon>
                <v-icon>mdi-file-pdf-box</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
                <v-list-item-title>Yecid Tovar</v-list-item-title>
            </v-list-item-content>
            
           </v-list-item>
        </v-list>
     </template>
    {{-- <v-list-item class="secondary px-2">
        <v-list-item-avatar>
            <v-img src="/images/profile.jpg"></v-img>
        </v-list-item-avatar>

    </v-list-item> --}}
</v-navigation-drawer>