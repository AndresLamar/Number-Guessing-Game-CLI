# Number Guessing Game

Solución para el desafío [Number Guessing Game](https://roadmap.sh/projects/number-guessing-game) de [roadmap.sh](https://roadmap.sh/).

## Descripción

Esta es una aplicación de consola en PHP en la que el jugador intenta adivinar un número entre 1 y 100. El jugador puede elegir entre tres niveles de dificultad: Fácil, Medio y Difícil. Dependiendo del nivel elegido, el jugador tendrá un número limitado de intentos para adivinar el número correcto. La aplicación también registra y muestra los puntajes más altos (high scores) en cada nivel de dificultad, incluyendo el número de intentos y el tiempo empleado.

## Características

- **Niveles de dificultad:**
  - Fácil: 10 intentos.
  - Medio: 5 intentos.
  - Difícil: 3 intentos.
- **Pistas opcionales** para ayudar al jugador a adivinar el número.
- **Registro de puntajes más altos** para cada nivel de dificultad, incluyendo el número de intentos y el tiempo empleado.

## Requisitos

- PHP 7.4 o superior.
- Terminal o línea de comandos.

## Instalación

1. Clona el repositorio a tu máquina local:

   ```bash
   git clone https://github.com/tu-usuario/number-guessing-game.git
   ```

2. Navega al directorio del proyecto:

   ```bash
    cd number-guessing-game
   ```

## Uso

Para ejecutar la aplicación, abre tu terminal, navega al directorio donde está el proyecto y ejecuta el siguiente comando:

```bash
php index.php
```

## Menú Principal

Al iniciar el juego, se mostrará un menú con las siguientes opciones:

- Fácil: 10 intentos para adivinar el número.
- Medio: 5 intentos para adivinar el número.
- Difícil: 3 intentos para adivinar el número.
- Listar puntajes más altos: Muestra los puntajes más altos registrados en cada nivel de dificultad.
- Salir: Cierra la aplicación.

## Juego

- Inicio del Juego: Después de seleccionar un nivel de dificultad, se te pedirá que elijas si deseas mostrar pistas. Luego, deberás ingresar tu primer intento.
- Pistas: Si seleccionas mostrar pistas, recibirás sugerencias sobre si el número es mayor, menor, par, impar, o dentro de un rango específico.
- Victoria: Si adivinas el número, se te informará cuántos intentos utilizaste y cuánto tiempo te tomó.
- Derrota: Si agotas tus intentos, se revelará el número correcto.
- High Scores: Si estableces un nuevo récord en un nivel de dificultad, se guardará automáticamente.

## Ejemplo de Uso

```bash
Welcome to the Number Guessing Game!
I'm thinking of a number between 1 and 100.
You have X chances to guess the correct number depending on the difficulty you choose.

Please select the difficulty level:
1. Easy (10 chances)
2. Medium (5 chances)
3. Hard (3 chances)

Other options:
4. List high scores
5. Exit

Enter your choice: 1

Great! You have selected the Easy difficulty level.
Let's start the game!

(Show hints? (y/n)): y

Enter your guess: 50

Incorrect! The number is less than 50. Try again.

Enter your guess: 25

Congratulations! You guessed the correct number in 2 attempts.
It took you 1.23 seconds.

Do you want to play again? (y/n): n

Thank you for playing. Goodbye!
```
