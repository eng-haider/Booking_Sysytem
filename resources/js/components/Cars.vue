
<template>
  <v-container grid-list-md text-xs-center>



      <v-layout row wrap >    
        <v-dialog v-model="dig_show" id="dig_show" persistent max-width="400px">
               <v-card>
                  <v-card-title>
                    <span class="headline" style="font-family: 'DroidArabicKufiRegular' !important;"> ألتفاصيل الخاصه بلمركبه ذات الرقم {{editedItem.car_num}}  </span>    
                     <v-container>
                       <v-layout row  wrap>

                         <v-flex xs12  style="font-weight:bold">
                           <h3 class="dodo"> <span  style="color:blue;font-weight:bold">رقم المركبه : </span>{{editedItem.car_num}} </h3>
                         </v-flex>

                            <v-flex xs12 class="dodo"  style="font-weight:bold">
                           <h3> <span style="color:blue;font-weight:bold">نوع المركبه : </span> {{editedItem.car_type}} </h3>
                         </v-flex>

                           <v-flex xs12>
                              <h3 class="dodo" > <span style="color:blue;" >عدد المقاعد  :</span>{{editedItem.seats_num}} </h3>
                          </v-flex>

                            <v-flex xs12>
                              <h3 class="dodo" > <span style="color:blue;" >عدد المقاعد  :</span>{{editedItem.seats_num}} </h3>
                            </v-flex>

                            


                        <br>
                        <br>
                        
                          <v-flex xs12>  
                            <!--  
                            <ul v-if="this.editedItem.trip_date">
                             <li>{{editedItem.trip_date}}</li>
                            </ul>
                            -->

                              <p class="dodo" ><span style="background-color:#fff !important ;color:blue" >حاله المركبه  :</span> {{editedItem.status_name}} </p>
                               <p v-if="this.editedItem.trip_date"  class="dodo"  ><span style="background-color:#fff !important ;color:blue" >موعد أنطلاق الرحله :</span> {{editedItem.trip_date}}</p>
                                <p v-if="this.editedItem.name" class="dodo" ><span style="background-color:#fff !important ;color:blue" >أسم السائق:</span> {{editedItem.name}}</p>
                                 <v-select
                                  v-model="editedItem.car_status_id"
                                  :items="car_status2"
                                  item-text="status_name"
                                  item-value="id"
                                  :rules="[v => !!v || 'يجب ادخال نوع المركبه']"
                                  label="حاله المركبه"
                                  required
                              ></v-select>
                         </v-flex>

                          <v-flex xs12>
                          <v-textarea
                              v-validate="'max:400'"
                              v-model="editedItem.notes"
                       
                              :error-messages="errors.collect('name')"   
                              label="ملاحـضات"
                              data-vv-name="name"
                             
                              > 
                            </v-textarea>
                          </v-flex>

                                             
                        <v-flex xs12>
                          <v-btn class="success dodo" @click="save_status(editedItem)" > حفظ</v-btn>
                          <v-btn  @click="close"  class="error dodo">خروج</v-btn>
                        </v-flex>

                       </v-layout>
                     </v-container>
                    </v-card-title>
               </v-card>
        </v-dialog>

      <v-dialog v-model="dialog" id="dialog" persistent max-width="600px">
          <v-btn slot="activator" fab dark color="indigo">
            <v-icon dark>add</v-icon>
          </v-btn>
          <v-card>
            <v-card-title>
              <span class="headline" style="font-family: 'DroidArabicKufiRegular' !important;">أضافه مركبه جديده</span>         
              </v-card-title>

           <v-container>
             
             <v-form ref="form" v-model="valid" lazy-validation>
            
               <v-flex xs12>
                <v-text-field
                v-model="editedItem.car_num"
                :rules="carNum"
                :counter="10"
                label="رقـم المركبه"
                required>
              </v-text-field>
                </v-flex>
        
                <v-flex xs12>
              

                     <v-select
                      v-model="editedItem.car_type_id"
                      :items="cars_types"
                      item-text="car_type"
                      item-value="id"
                      :rules="[v => !!v || 'يجب ادخال نوع المركبه']"
                      label="نوع المركبه"
                      required
                  ></v-select>


                </v-flex>

                  <v-flex xs12>
                <v-text-field
                    v-validate="'required|max:2'"
                    v-model="editedItem.seats_num"
                    :error-messages="errors.collect('seats_num')"
                    :counter="2"      
                    :rules="seatsNum"
                    label="عدد الركاب"
                    required> 
                  </v-text-field>
                </v-flex>

                <v-flex xs12>
               <v-select
                      v-model="editedItem.car_color_id"
                      :items="cars_color"
                      item-text="color_name"
                      item-value="id"
                      :rules="[v => !!v || 'يجب ادخال لون المركبه']"
                      label="لون المركبه"
                      required
                  ></v-select>
                </v-flex>
                
                  <v-flex xs12>
                <v-textarea
                    v-validate="'max:400'"
                    v-model="editedItem.notes"
                    :error-messages="errors.collect('name')"   
                    label="ملاحـضات"
                    data-vv-name="name"
                    > 
                  </v-textarea>
                </v-flex>




                

                          
            <v-btn
              :disabled="!valid"
              @click="submit"
              class="success dodo"
            >
              حفظ
            </v-btn>
       
              <v-btn   @click="close"  class="error dodo">خروج</v-btn>
              </v-form>
           </v-container>
        </v-card>   
      </v-dialog>

    <!--
       <v-btn  @click="all_cars"  dark color="error" style="float:left">
                  <p>ألكل</p>
          </v-btn>

        <v-btn  @click="booked"  dark color="error" style="float:left">
                  <p>محجوزه</p>
          </v-btn>
          <v-btn  @click="booked_up"  dark color="success" style="float:left">
              <p>غير محجوزه </p>
          </v-btn>
          -->
        <v-flex xs3>
              <v-text-field
                    v-validate="'required|max:2'"
                    v-model="editedItem.serch_key"
                    :error-messages="errors.collect('seats_num')"     
                    label="رقم المركبه"
                     @change="serch()"
                    > 
                  </v-text-field>
        </v-flex>
        
        <v-flex xs2 >
              <v-btn
            
              @click="serch"
        
              style="margin-left: 72px;"
            >
             <i class="fas fa-search"></i>
            </v-btn>
        </v-flex>
          <v-flex xs3>
                     <v-select
                      v-model="editedItem.status_id"
                      :items="car_status"
                      item-text="status_name"
                      item-value="id"
                      label="حاله المركبه"
                      required
                      @change="status_filter()"
                  ></v-select>
          </v-flex>

          <v-flex xs3>
                     <v-select
                      v-model="editedItem.type_id"
                      :items="cars_types"
                      item-text="car_type"
                      item-value="id"
                      label="نوع المركبه"
                      required
                      @change="type_filter()"
                  ></v-select>
          </v-flex>
    </v-layout>



      <v-layout row wrap>
        <v-flex xs3 sm3  v-for="car in cars" :key="car.id">
          <v-card>
              <v-toolbar :color="car.css_color" style="color:#fff" >
              <v-btn icon  @click="showItem(car)">
                <v-icon>fas fa-plus</v-icon>
              </v-btn>
              <div style="padding-right:15px;">{{car.car_num}}</div>
            </v-toolbar>
            <v-card-title primary-title>
            <p class="card_item">نوع المركبه :{{car.car_type}}</p>
            <p class="card_item">عدد المقاعد : {{car.seats_num}}</p>
            <p class="card_item">حاله المركبه :{{car.status_name}}</p>
            </v-card-title>
      
          </v-card>
        </v-flex>
      </v-layout>


  

 

  </v-container>
</template>


<style>
.card_item
{
    float: right;
    text-align: right;
    direction: rtl;
    padding-right: 22px;
    font-family: 'DroidArabicKufiRegular'
}
</style>

<script>
	export default {
		data() {
			return {
				cars: {},
        dialog: false,
        dig_show:false,
        car_num: '',
        filter_now:'',
        maints:'',
        car_status:[],
        car_status2:[
          {
              id:'2',
              status_name:'انهاء الحجز',

          },
          {
             id:'3',
             status_name:'صيانه',

          }
        ],

        dropdown_icon: [
        { text: 'الكـل', callback: () => this.all_cars() },
        { text: 'غير محجوزه', callback: () => this.booked_up()  },
        { text: 'المحجوزه', callback: () => this.booked() . Fire.$emit('bookeds')  },
         { text: 'قيد الصيانه', callback: () => this.maintenance() },
       
        ],
        cars_color:[],
        cars_types: [],
           editedItem: {
            car_num: '',
            car_type_id:'',
            car_color_id:'',
            notes:'',
            seats_num:'',
            
          
           },
        selectedItems:null,
            valid: true,
          name: '',
          carNum: [
            v => !!v || 'يـجب أدخال رقـم المركبه',
            v => (v && v.length <= 10) || 'Name must be less than 10 characters',
            v => /.[0-9]./.test(v) || 'يجب ان تكون ارقام فقط'
          ],

          seatsNum:[
             v => !!v || 'يـجب أدخال عدد مقاعد المركبه',
            v => (v && v.length <= 2) || 'عدد المقاعد يجب ان لا يتجوز ال 100 ',
            v => /[0-9]/.test(v) || 'يجب ان تكون ارقام فقط'

          ],
        cars_show:'',
				select: null,
				selectedItems: [],
				custom: {
					car_num: {
						required: 'يجب ادخال رقم المركبه',
						max: 'The name field may not be greater than 10 characters',
					
					},
					select: {
						required: 'Select field is required'
					}
				}
			}
		},
		computed: {},
		methods: {

      serch(){
          Fire.$emit('serch');
      },

      status_filter(){
         this.filter_now='status_fliter';    
          Fire.$emit('status_fliter');
      },

       type_filter(){
          this.filter_now='type_filter';
          Fire.$emit('type_filter');
      },

			createCar() {
				this.form.post('api/cars');
      },
      
      
      close () {
        this.dialog = false,
        this.dig_show=false,
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

			submit() {
				if (this.$refs.form.validate()) {
				axios.post('api/cars', {
					car_num:this.editedItem.car_num,  
          car_type_id: this.editedItem.car_type_id,
          car_color_id: this.editedItem.car_color_id,
          seats_num:this.editedItem.seats_num,     
          notes:this.editedItem.notes,

				}).then(() => {
					this.dialog = false
          Fire.$emit('AfterCreate');
          toast({
            type: 'success',
            title: 'Signed in successfully'
          })
        }).catch(() => {})


        }
      },
      
      save_status(car)
      {
        
          axios.put('api/carsupdatstatus/'+car.id,{ 
          car_status_id:this.editedItem.car_status_id,
          driver_id:car.driver_id,
          ticket_id:car.ticket_id,

        
          notes:this.editedItem.notes,
          }).then(() => {
					this.dig_show= false
         Fire.$emit('AfterCreate');
          toast({
            type: 'success',
            title: 'تم تغيير حاله المركبه'
          })
        }).catch(() => {})
      },
			clear() {
        
        this.$refs.form.reset()
				this.car_num = ''
				this.select = null
      },
    
       showItem (car) {
        this.editedItem = Object.assign({},car);
        console.log(this.editedItem.id)
        this.dig_show = true

 
       


      },
      cars_type(){
        this.$validator.localize('en', this.dictionary)
				axios.get('api/carstype').then(response => (this.cars_types= response.data))
      },

       cars_status(){
        this.$validator.localize('en', this.dictionary)
				axios.get('api/carstatus').then(response => (this.car_status= response.data))
      },

      cars_colors(){
        this.$validator.localize('en', this.dictionary)
				axios.get('api/carscolors').then(response => (this.cars_color= response.data))

      },

			loadCars() {
        
				this.$validator.localize('en', this.dictionary)
				axios.get('api/cars').then(response => (this.cars = response.data))
      },

    

       all_cars(){          
            this.cars_show=this.loadCars();
      },

    },
    
		created() {

       Fire.$on('status_fliter',() => {
            console.log('cats_filter');
             axios.get('api/car_statusid/'+this.editedItem.status_id).then(response => (this.cars = response.data)) 
            
        });

          Fire.$on('type_filter',() => {
            console.log('type_filter');
             axios.get('api/car_typeid/'+this.editedItem.type_id).then(response => (this.cars = response.data)) 
            
        });

         Fire.$on('serch',() => {
              if(this.editedItem.serch_key!=null)
              {
                console.log('null');
                  axios.get('api/car_serch/'+this.editedItem.serch_key).then(response => (this.cars = response.data)) 
              }
           
            
        });


      

     

       this.cars_status();
       this.cars_colors();
       this.cars_type();
      this.loadCars()
     
      
        
        
			Fire.$on('AfterCreate', () => {
        this.loadCars();
        
      });
     
		}
	}
   </script>


