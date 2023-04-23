<template>
    <v-footer app color="blue-darken-2" class="footer">
      <v-container>
        <v-row justify="space-between">
          <v-col cols="12" md="4">
            <h5 class="text-uppercase">Вступ</h5>
            <p>
              Кваліфікаційна робота робота бакалавра з теми "Веб парсер"
            </p>            
          </v-col>
          <v-col cols="12" md="3" class="text-end">
            <h5 class="text-uppercase">Credits</h5>
            <ul class="list-unstyled mb-0">
              <li>
                <p>Виконала: студентка 4 курсу математичного фак-ту гр. 6.1219-1пі Барнаш Марія</p>
              </li>
              <li>
                <p>Науковий керівник: к.ф.-м.н., доцент Лісняк A.О.</p>
              </li>
            </ul>
          </v-col>
        </v-row>
      </v-container>
      <v-divider></v-divider>
      <v-card-text class="text-center">
        <span>&copy; 2023 Mariia Barnash</span>
      </v-card-text>
    </v-footer>
  </template>
  
  
  <script>
  export default {
    name: "Footer",
  };
  </script>

<style scoped>
    .footer{
        position: inherit !important;
        display: block;
    }
</style>
  