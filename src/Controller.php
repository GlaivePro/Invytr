<?php

namespace GlaivePro\Invytr;
    
use Illuminate\Http\Request;
use GlaivePro\Invytr\Helpers\Translator;
//use Illuminate\Foundation\Auth\User;

class Controller
{
    /**
     * Display the password set view for the given token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSetForm(Request $request, $token)
    {
	// TODO: šeit varētu sesijā izdarīt atzīmi, ka cilvēks iet setot nevis resetot?
        if(view()->exists('auth.passwords.set')) {
            return view('auth.passwords.set')->with(
                ['token' => $token, 'email' => $request->email]
            );
        }

        Translator::replaceResetLines();

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
	
	// TODO: jāuztaisa apstrāde rekvestiem, kas atnāk ar sagatavoto linku
	//       kaut kā middlewarē jāidentificē viņi un jāveic korekcijas, ja nepieciešamas
	//       jāizdomā, ka konfigurējam expiration
	//
	//       ja taisām sesijā atzīmi, tad midlevārē varam noķert, palabot stringus u.c. stuff
	//       un izdzēst atzīmi no sesijas, lai tālāk galvu nejauc
	//       bet jāparedz iespēja arī custom apstrādei
	//       tjipa ja ir metode kkur (probably tur pat, kur resetam?)
	//       tad returnojam App::make('Kontrolieris')->metode();
	//       citādi customizējam lietas, lai reset procedūra nostrādā mūsu vietā
	//       un ejam default ceļu
	//
	//       varbūt arī šādi jāpadod conditionally izsaucamā metode
	//       https://github.com/laravel/ideas/issues/385
	//       nav skaidrs, kurš variants pareizāks
	//
	//       pirmajā nav skaidrs, kā nenobojāt sekojošās midlevāres
	//       otrajā nav skaidrs, vai pacieš route cachingu
	//       ja cache ir ok, tad ejam otro ceļu
}
