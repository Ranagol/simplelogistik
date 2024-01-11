<template>
    <el-select @change="updateLanguage()" v-model="$i18n.locale">
      <el-option v-for="(locale, i) in locales" :key="`locale-${i}`" :value="locale">
        {{ $t(`lang.${locale}`) }}
      </el-option>
    </el-select>
  </template>
  
  <script>
  export default {
    name: "LanguageSwitch",
    data() {
      return { locales: ["de", "en", "es", "it", "fr"] };
    },
    methods: {
        updateLanguage() {
            sessionStorage.setItem("locale", this.$i18n.locale);
        },
    },
    mounted() {
        if (sessionStorage.getItem("locale")) {
            this.$i18n.locale = sessionStorage.getItem("locale");
        } else {
            sessionStorage.setItem("locale", this.$i18n.locale);
        }
    },
  };
  </script>