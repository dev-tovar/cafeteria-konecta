export default {
    data() {
        return {
            rules_form: {
                requerido: v => !!v || "Este campo es requerido",
                numeros: v => /^([0-9])*$/.test(v) || "Este campo debe ser númerico",
                numerosComas: v => /^([0-9.,])*$/.test(v) || "Este campo debe ser númerico",
                numero_capacidad_entregada: v =>
                    (v && v.length >= 1 && v <= 8) ||
                    "Este campo debe contener al menos a 2 y menor a 7 caracteres",
                alfanumerico: v =>
                    /^([0-9A-Za-z])*$/.test(v) ||
                    "Este campo no permite caracteres especiales",
                sololetras: v =>
                    /^([ A-Za-zñÑäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ])*$/.test(
                        v
                    ) || "Este campo no permite números ni caracteres especiales"
            },
        }
    },

};