<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');

//set_time_limit(300);

class CGPrueba extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("oficina/gestion/MGPrueba");
        $this->load->model("dominio/Mcarroceria");
        $this->load->model("dominio/Mvehiculo");
        $this->load->model("dominio/Mhojatrabajo");
        $this->load->model("dominio/Mcertificados");
        $this->load->model("dominio/Mconfig_prueba");
        $this->load->model("dominio/Musuarios");
        $this->load->model("dominio/Mhojatrabajo");
        $this->load->model("dominio/MEventosindra");
        $this->load->model("dominio/Mpre_prerevision");
        $this->load->model("dominio/Mpre_atributo");
        $this->load->model("dominio/Mpre_dato");
        $this->load->model("dominio/Mcontrol_salae");
        $this->load->model("Mutilitarios");
        $this->load->helper('download');
        $this->load->dbutil();

        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public $llanta_1_I        = '';
    public $llanta_1_D        = '';
    public $llanta_2_IE       = '';
    public $llanta_2_DE       = '';
    public $llanta_2_II       = '';
    public $llanta_2_DI       = '';
    public $llanta_3_II       = '';
    public $llanta_3_IE       = '';
    public $llanta_3_DI       = '';
    public $llanta_3_DE       = '';
    public $llanta_4_II       = '';
    public $llanta_4_IE       = '';
    public $llanta_4_DI       = '';
    public $llanta_4_DE       = '';
    public $llanta_5_II       = '';
    public $llanta_5_IE       = '';
    public $llanta_5_DI       = '';
    public $llanta_5_DE       = '';
    public $llanta_R          = '';
    public $llanta_R2         = '';
    public $salaEspera2       = '0';
    public $ipCAR             = '';
    public $informeWebCornare = '0';

    public function index()
    {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }

        $cadena        = "WnNBUXhienBwS1JmckFRaklYc2h1TTd0b0JQdjcwMTJxWkZ5T1FuMmJlZStiOFQ4TkJ1UEQ1aTRkOURoTm9odkFFZ3FNSG5FOHlRcVhYdDJXeCtsRE9FbnRLOVB0NFBIc25SeGdVOFQ2VFMrU2xNQ3RSQzd2cEpOT3krbWRtNDZhMklGTklIZ3ZmZDMrakdyL09KZm9GNTN6ZmJtK0FLaXY0RXI3MmRWU3p6V1FzaFc4a1JTV1BRcEk1NUd0aS9HOVlaVXEveUh6YU1PYTBja1UyeW5Ia0NRb2lzakw3Y0NPc3dwRWt3UkpNTnE1SEVHRFZNYm5hN3R0U0V5dE4rTnk3MnIrejVvTnBQanBRU3VLSWxRbXlrdDI5NHpJWGM3V1BObC9oYXlSQUNwekNoQUMxamhUeC9LWTJZYUY1b2tQQmxKelhRNVltemlDaGxFeFdyYU1TNUJpK3BuVEUxT2tmR0RHdVhDNHhtWWZta0d5OW51Y0kvL0YxS1llODcxM0ova3JzQ3lrV1gzT212Qmlsb3BnYVlvWkJ3MEJBME9YOVpRZGlWMGZtNXFkYm00Q2pKZzBPU3duU1lsTHJWcGRpcXZGUWdlTis1dnhqcTlac1NTR2IzNzRFQ0VrNkN4V1JXUkMvVFBsSnFlTDBSM0Y0KzB5ald2T29ROUlLZVE1WmdWNk1XanVVUkxGZjU5V2NseHcxRU1VQ1B1ekp4c1NYTkdYMkU4Wi9pd1pDcEViR3ZOdENxczFpWmlyNDlIZ21WcE0xSkF0bU9BSUhiRWZhbEV4ZjJNQXJMUVlyTTVYREZCcW8rZ1poUS9icVBWcTRha3JST3k0WEhrLzBLMEpEV2hQRnBrR0xRcXNHZkZyY2NKUFUzTDVhODJqMXVJVDVqdEJJaitodTdyeFQ1cTcxcGN2cy9YQlkrYU05amZBQlNxVS9ObUVBMVU3eTFqZEFOUUt2TnJ6a0VCQmhxUnRHZXJtM0RxbmU0SnI3ekR3MDNuZVFFT0plN3BCeG1WSnNaSTROcnNMeWRHMm9iQlpPSHJRbWh6Q1diUmd5a1liZ0ZDUjRWS2czMjBjWXlMUTEvS1ZHSFFzZkplNjV2ekY1VTl0MEVDQXlkOFpEWXFCa1g2N3BlWFhRZ0xyaHhwR0ppS3NkMyttdlZVMjhrTXB6TVRuMFJpd0tNWS9QSDZDZGFKbnVETWhSMkswT1ppMnBCMU8wM1ljRzR3eGcwUHh0SlQ5U2p6RmRjRVBUdHg5L09paWQ4THdHQVR2VWV5dTNPSFNFWDVhamd2c1VOQzB3NkF3Z2N4R2g5K3p4R3lxUFdONzJlMXVZMW5kV3FaRXRFQ3lNRU94c1JJVzRGcEt2eWtJcFIyUG94eW10S1AxY0Z0SUFBa0R3dThSbGJ0WVp1eGk3NTFhcjc5ZkZ0TEZldi9lVzZkQnZKRXZ2Y3JhNS92ZUtYY0tha2E4b01VakVRZzRKSVZpR1RFSWhnT3dlMlZEWjNtM0U5cU9kQThNU24vdFlZOHNIajR2cS9DOGo5WFMzdUxnb0l3bDVhVkZFZGQzQ2tOd0VqWHBVQkRaZ1c1b0NHQXNLR1dQUlpYa1I4VHQwb25KdnduT1htbC9jZ2NxWUQ2eHdmcWl1QmFBeE9aTURjSml5SDgxaWJ2bDNNSVNjTFFKNXh0U0ZlenJwMS9RQTFWNkFIMjNCblJnLzNGQWpVSTlPRWVWMGRpQjM4TVkyUW5MU2s4Z05yU215Z1YwL25DS2FmLzJSSFhpWDlIY3JvUnRkQi84WWJGbTVILzY3RTNkR2JvOXloVENSQzA4ZjB5ODhuZ0RVZEovWmkvZ3lJdkUrLzdkcXNsVnJuZlM4c01mZWlnVFpROHY4RjZmU2hYUXZuMW1HOHM4QlpYYUVGTTRqaFJkcWN3RzdJSnhqZ3NTSm5uZ0pyNkZwNzNkT3Y0dzFnSXhSQkhGaGN5WlFSVHVjaFRxZUNuM0FZTk9aQzd1N2toOEE1a3hUK01HVmNHTVcxbFVZaUtHVExOSXYwTzV5cmNpQkJiYm1PNTMzaHgwemtwRlphenF2cWNOSnVtd0trTGxEMFkxMUJqQWpGQTFpR2pCaGZXR09MMytoNGtHVXZPelhjSFRXL09xdFlVZkQ4Vnl4OHlzcjMwa3NRUHRuM0xZeHpRUkxCSnZBUlhLTk9yaFM0OFJFeXgxWmpVVUpTNWVhVU9zOHNyRDA2bTNxdHhDUmZFQlJLUnkvUW5VSnFXUHNnbFBGSERSQ0hSWHJRQXRFNDNIa3lTMXVPTE5raHhFWll3SVRtUFlrdkZBV29BbmQ5SDRSSUY0VlBaWENzMWx0NTRWL2laVkpDb1hDQy9xRzJLM1ZPNVBRZFprL2tOU2lxV3g4UWFtZ1I3UzVrc1pDclV0bWtjZnZlNlFiOHphZXM0MkVBUmpJVjZYci9XM2JFZHdiUVFMK3lMOWxNN3FiSzE3bXVYVlBWck9sc2xVTGY4ck9oa0tPc0hXR0FqVk53ZG9nWGk2dFRhcXhYMVl3OGcvTS9ROCtWZ0FwWndpQzBKU0RoVW5HSnZOSmxiSDFVVC8xSktrRGVWMzhFT0w0emVlU2lxK2JHMDVYeGJsU1VtZDY5K2FpaXBnUmZGdlhrTXRtUXd4UFZVVTlHMVBIMEE3S0lNcXZDeXROekk5SkZLaHVhL0JhL2hqUXlpVlQvRFJXZzVCR2tGTVNyQVBtR25DM0VlZUdPVHBGZmFXY2xZdlNQV05UUmw0WVZJZXR3NDFQVkFhZkI5Q3dQWDQ2czFwQjRxMG5WZ2htdmdiY2tQMnJ3SG9MaWVkS25DY0xHd1BwemRJSUV6NEtrRGVNNHA0NDhDbC8zdjR5WmlEeDZMcE9lOC81c2F5Nkp6Q25ENHpDdk9uSU9ja1BzL0NLZEVlZzlQWW1qVm9JZUhQWDJzQ3I0U0Qya1VyU1lTSkVJeEhCWURQUS80K2dMamhFbVI4bnJ0ekFrOTNCcVdSVTB3RXhSTXV4bFRnSW1pc3pjdEJUNloyOFdkdXBIQjRUcDBVdXZKZWliUVM5OU1qZnM3OXdyblZveVVYWHVpQkplMnFVQ0FMNml5NE9qSk4wWjg4UnhGR3cxNlh6OVYyY1E1ZlE4endxZEYwOG5zZUEyOXlYUGVkckdzNkp3NXlxYUJvOTIxUktjWEZZOVNmL291ejBUcEFQMEIyNDE0QVpFV2RKWnBiLzhDZ1o4VWV3U0poK2JYbC9udmUyNnZsbVBFRTYzcDRyeWxUZnp2WklFWWdpdUlEcTI2dEp6RHMwSXlxRTlobC81djNuOUE2RUJWcHl2ckR3cDhlYytRaDNyQXlWQ1pnRklBY2hUcHd1dW54cXhidnR5ZFdEdHIxbGZTY3ozM1l6ZUp5WHh6ejVUUGZGd2hMS0VrNnNibzZ5WGtscDY0NFBpaGt1NUdnbVBlWjkvZjBVbHQ2V2VSTnhhellVS2ZzY1FnVFlFTnBOSVloY3FGR080dnhlQk1JbmVDeC9DRFdpUUQzSDlDdHRhTlJ0azRDOWVOdU1QOXRJQS9pbzhVKzlOSmhPbFJ5Y0ZYVkN6V1dzVmg5L1FLa3hKMlR3VStlSzV2M3BoZUVmZGkvUlR1a3hscU5WaWpoblRSOVJFWWY0N3lYUnN4N3Z1RFR5OFNPNXUwRFp4NVFrOUtwc0xvcGx4bDM2Vy8wV0FrV081TWxLd1pqdWFLbjJQY1VNSWs4cFpBM0RTRkJ2a0xrdlpWSnY1MjFPWVA2T3NDOTF2OVdzSWx1OFdCb25nVm8vMzJrbnIrOWFaelFoTkJMLzliUVFIZnRQNmVZSWZWYW9FeWpJdlRKUzFEWHQ2b3JDTVdmYWh0N0pCZmlXMDliWDdBdHBVS2R4MHlweTFpZTV5WWlaK0JVUmI0c09hOEl3UXNqN0x6QmdoQnB3cUg4M3N0ZGFLTmg3dlB6Z0VCYms4RksvK0ROdHBlWVVtSU5Od3Vyam40V3V4NlFoMU10NFV4RklXMXQrajhRVzZQaXZWdG9tTm1DQWVjSXB4YWU0NzArN2g1WmVVSTVZUjkzZzA1U0JvNTU4bVpaaExpWmNPd3dwZ3MySlIzYVBVbktzY29VTXRrSm91MHlxb2pTVlp3VVBKeUk1a3Q4YzNsM2lHeWFQUjZCaG9ON0VNdXdkbnk4aGN0eXRxSnVmMGRlOTZhaFIzUG1jRmxaMEIwK3N2T3JnZnIyaTVJWTZobzhnVkJlY20rMGdCcHVHa2p2MG11YlV3RWZFTHRnTjNHRVpESlpVajQrbGkvczRTWUYrUHlVTXU5R1VLVmNGKytmSU9IM3ErU1FQL1U2WFlYV09YSDE2MnloVk1FMU40S3JqQ1k5a1U4MDVRdzNLazZZZGkrWjg2QW1USTVhWlVITjRUYXA3OXVNQTZ6TU1sTG1qZnRDOUJzS1lVQlFLekVMQkNXa1JFSUsrVU9Ub1hPRE1rSW5XWVJDazZNbTJhRHRrR2p6M2xuWjFqSzcyY3c4VGd6KzdwZlJQVWxKMVhwcE9EclpqL2hSZ3V4TXUya1M0RG5sY0VlT25VNU10RUlOQkQzMGZ2YWtGNFYrNnZDVXNvTUhTR1h0N0Q2aytZYzFQQmF4VGd0d2IyeUVJSG5kWG1yZGp3TDBndVpqOVp3TXBYcjJlb2FoMmhobCs2REQ0Zm5JNWoyTERQYTluZzNkelZzVkNxL1duSzNySElobklkdjF2MFEvTGh2WVgyU3Z0NWY2SUg1YXJsVC9HT1VVeGtDVW9wMUd3b0RLYTV5Zjc0MHJLN2JVNnVibnI0RE94bGk2REpwVlpnWXllaG0rYS82SnB0cGQ5VkVsUmlYQ2kwbHVYUWlYZWlwblY0OGErTTlyR0lsREFZdStFbjRrdENBZjBqM3VKZ1VLOWFUNXZBcDNSdytxSzNmNldyQUxiRnhXNTVZeDV6S1pYOWp1WmtqZ1F6MzZDK2FVMXA2K0h3aEFVT1owVUxWN3p1SVBJaGdwUHltU1BJWm8xNzFhNVF6MmpOS3dNVzFVUFFCNnRtaXVwbmJBMVhleU1EWXlOWkJvalFlSGhncW1NdFJJdUFPUmR2MTFkTno3VGg4ek1CMmNZMWNZUFNXajFGMnBaM2JBQXpGYzZHMzIzakc4NWdYcVUzZXZQb0NOcFZrOHFjMndMZDE0UmNaeFhvNDNvQlh6N01XaGVlSlNLRW5Kbmh0TFVxQ28rWWNUV2s5a1c4Uml4cTE4Q2ZjVWVaeFBOLzhxRFB6MVBUb2tNVzVZbFdYRjRTUzN2dkRSVXp6cGtTMFVoN3ZjQlgrdjhDakp1dVY5VitWL1ZPdWxweGx0SkJDTnFMdFAyL3ljRGlvK0RIWG9ONU4rdTRDdi9TMkI5MGMyMFFmalZHOWJsZWlEa0t5MlptNVN3N3RZVVNyd2cwWlJ4U3cremdxN2ExblprZERGd29FeU55cDZjajBLdEJhUlZsZkdiYmswcXdtVzhIcFhlTGVVQUM4N1BTRjRBWWQybm9uYjQ1d3IyMmQrSzhJazlsREFVNVdyNUwyZkpBZXRUNHNsSHBkMm0wUXdSZEtwSmJISnNsSGdUNWQ3L0lYczgvaGpoQy9taWlGUTkvOHZOWXVvbVBtSk80TXVhb0NFVTQrN3hiOWZZdFN3RE5wMjE2cHI5Zkt3V0VhU01uVGl1OXlJdThrMkF5NXFSNHpJdjRnSythaDlHWXBPVHJLMEZ4NHJ5WHJjUCs1RUhxKzZ2RUNJa3AyelFoV2FIb2dvdGdhQVEzVjRvTlNScld2aGR0ZkpESjBsaEQ4M2MzRjVCcG1OMzlPQi9XRlc2VTNJdmZvWDd2R0s1MS9tbXJJaEJEQ2FyYkNrWms1aGtsaFZvSENTaU01d1pmNjRyV2FPdXRyNExXVk1NRm9Nb2hxSVJWb1R0aG44R3hTU3cxVkptcEhnUGFReWloSHZ6ekc5R096cCt6YW41eHdRcDFiUnpLcnBLQmg5TnpRa0xQamxkbjJuNWl5K2VtZ2dYcys1VlJoK1c1eXRBL1pLUWZrUFpSOEwzNjdSUDhsM0YvbklYNlRoSm4yRHQrNlVmcFB5Y1ExbnA2YkpISFdERHJ6V0FmdytDUkFFL1R2eXBRaG9GV01DQmdWN0M5bXNHTDJndUFTdWU1ZStCcXljVWlQalBqSG52TGRBZ0R1OGZjN2srTlFMOTRlK056RVBoOElJV3VmVm1GNWxkWGlyMDVYNTJVY0dOZW93Z0grRElwVnplTDFVaTFqS3hndytqaDhpUTZhVEF0eW4yaGhRL1hnRW9KUCtVdFNLUHlHL0ZsZzZkeFBaOGFqM3dWalhPbHN1Y1dycVpUVjRYVFFZa2c3ZkdoR014bHhLUmRuMXlOUEd3QWxEaFhlOXRPZHhJY1NBVk1GeHFoVGM1RGNudExBOFE1NnB4Zy9zUGhPVUp3NVlJdnRTUjAweDRmWjRuV1FISERKdnJtN3V0MXFORy9YWHMyZUJKbmp1cTZPeENJdWRXeGdwTzVKbUFnS20vellkRTNXZEhnVGpQYVNzWW5DVzVRaWdYRVVRMExPNWFoZ0YwQnRWY0JxbjJrbThGQXBnNUsrNS9lWFl2OForVEY5L0EvUENzZDFUU2FPTnZ5bWJNS1IvTFF6ekhrblBxNjZlQVNrcHhYSzJXTWtRSjNGVHZhajFBNHhHN3BwSGFXSXdWV3d3amV4bmtLd2NIb1Zvakg5Ky84WGRMcmdFa2d2Y2VMMGRvbzFmY1BOSDRGY0pIdnlST3hxaDFrRDBOOUY1dHkrVTN5blpuOVVJZ3VEczBLY3lIZDVCZ1ZJdTJXQWNBTC8vamFUUUc1ZUJUVWxIUi9Sdlg0SkhHSWFidGI0Qzcxb2RHMEpieURqQ2RKNFB0Mk94MDA3S0RrekpMR00vVGtEa3drZmNYNkdGMk5HNWk0UVBheWJrd3NCbU5QTmlJalFvQ2t6YXc1RGxkRXgyY1k2SnQyelQ5ZEs0aUlIOHN1V0hnUk1GSStVNGdRazQwVmZLcUlVaC84MUQxWVdtNXc5MkJ1ZW5FTElNM1VTYXYzQVNWb21Ud0ZYWHZDTzhNVmRpYXRETFQ0bENlLzlTTlN0UUZneGxvdm14UkQwNnpKZkRnRHk2VkZBTWdIa3Y2QUdnNWxKckJYZWo0NTcyOXR1ZnZZajdUZUc3VDUzdFhBdHJOT2tFOXZsU1V4ZFdiaGlkWTdwRG9lWTc4WVlneFZIaEFDcG5MR2tGV0NzRDBWdGFiMEZvRXEwSXY0ZDI3dXk1ajZ2c3kvMGZFRTM2dHI0N1Y2UjJ6d0VwWndxemExUC9DS0pHOE9vTDlpUGlBNFhIMFNUUklrM1A4ZXpzRHRuVEczZHRFS3lYNS8xYk01NFk3UVcyUUMwemd5NXA1ZDJsMXZvN2hMNnlmV0cvUTBxdjhYdEJNbkI4ZjBibjVISWI0MnQ1SkJTNEwrOVF3ZlpTWjFoK2gxRzNCeFlrNW9sOTFqVk1oRmhTU3dzelFPYzAvc3ljdUdPMlFYMnJCci9FTzBZNHhJeGRPRnVkcjg4RjFzK1ZVeTh5eml2MThmd0xkUlQraVBpOGl5OHkwd0VlYjAzQWxmQlRuQjhmRCtHODdWUWdRVmZPQmhCK3p0UHVmZ2tJZVBxSFh2TUFsa1M2OXNRREkxblpHNkpLQlB4dnZiNXJWd2hPOEh5REtXT1hzZGhxQUVNcFRra0hMaXJWVmxjMkdReDhDaG5NMXNHWjAraTVPaEU0SUduSFhscExiYmk5QnRZN2ZXalZXdkI5ZVMyY1o0TWJhNHJOTEx1eVZyUERHMWljbXgyMXo3WjI1WWFEallsREJIU002SWtvUVN0RjRmajJvdDROa3BDWHFPZ2YzSUlrYVNpclBEUFhxd0I4K1M4VjlGUnpIWGNwZis2QkltNitZR3dSekdsTFdydEkzRk94RnJqNTlpcjZDdzJkUzJRTzZGcStCS3pYUnhrUFJCL0pmS08vU0dhZ0o2dEZ4RnZWVitpLzFua2k4YUNRR3A1MUZIMUFERkZwUXNCZVNsU3laRUpJMWUxRGRWb0R0MEhPRVFOTm5KTE9UWHQzbUpoOXJIOE9HVVpIQ25OcmxlTzZiNXVJT1NXeFdSSDRvV0hQTkJsUXpWbkJPT2RjZm14OG5Td3E3NmI4M1Uyd1V4Q3ZUUzN5TDYyVGZYRGlidzhJUzdSb1dYOWNGd0h3d1BnRkxSVkp5V09EZTVHQ2U5aE9WMi83Ulk2bzhucERydnRZb0ZYdWluYWdHTjNiRTdsZi9sTDl5TDRsZ09IUnE2THczWHBGSzhGNzFQTUE4MzNhanhWdGxMaFdRSUQ4by9JZFVkYm5Ea3Y3YUNzV0l5b1RpdFdUbmMrMU05UVgyOTRjdkhEdHZNOXI1RXpYbUQzRkMwZy9GeE14K2tiSUQxeXp4aWg4TmpSaFM2LzN1ZXV5cFBOOUMvUGJOUEZUWmhuN09RWFVPNlplSU05cnR1aEVMekk5MldHd2FkVlEzeVV3VGJxM3hBVlAvaVR4aXU3TUdkWTZRaWUwc3I2YjQyYlM3cXZhNFM0MDE1VzBHZUVTeDBpWVhkTm4wYk9IT2o2eHI4Y08vR3VwQ2pFVTFUYTBGTS9DOEoxRndpWWp3QUdFZndNWHJzcjlETWNTRXBhdHBKUys4UmRQMnpEeWU5TEFDejcwQTEvRS90em5TUEVCZWpXVFZ2bmlrM2tEdFAyN2JFYzk1NUx0VzNWSFQ4WngweVFSYk0vd1BwN0kzaHFNUXlVR1BJMWZvamFTNXd3Sk1nMFEyWmJ1WlFyYTAzdEJZVVRKNFhpdWFYZStzdHhWODlKMzNCRUN0Tmh2NnlnNExkWFNndlRZaG5sbmM2QWNWMlhDUWZMaVpmcWI4Nlh2R0R0cEVBNlQzcE1uUDdYMDdoZDlyZGNROWx2cGRYR0I0a05lRWZNM1NZQXdITGlxeHhFR0tMV2Z2emYrSjRUWHRnYTJ1RmgwL3Nzczl4LzdiOENWaVBObkM4VTVxdnFGa2JoRGVIaVhXejk1V2FBaWtvRUFHUVJpOW0xeGVOenVyVE9ZajJCRVlZY0RUUmJpT3UxK3RsbThxYVRYNW1ZUnNEWklNWGlBZHBZWUw0Q2I1MUNRWU5VMWR3dUVFMyt1L2drTkNWR2RWUndrZGFZU0pCTVp0ejNnSFdDcUdDS2VJZFdmWGdZNEU0SmN5OXJiY0RQNXB4eUlIdjkyOUFRc3NHK3hwc3VWMzRKZlhKbGU4eWxBYnZnMS9sL3RXL0wvUXJlZ2pjeGJSUk05bmkvd3hQOE9HZDIxeUpZNGRUUWhVd2wxcGdyN3NYK1F1RFNJdUlJZmxwN0lhRFNvWlJudmI1bDk5aEhJb0RhektvMVhaN1pCZUtWSHNxRDgxcE16R0MrWDVodDZtdEV5N1YxQyt1WGZEMkxLMXArQ0xYQ0NwUXF4Vm02SndlK0tNR2N0YkgyUkNxOEh2UTNJQnBSbVlqNHRHZjZzYXJ3OGcza0lON295RzkxMWkwd3VQakRKeDV3R3dWQ3FoaUR1ZkxPSkZRTWNnRnRpVEtEVEE4V0NoNENZcFZPN3JTMkJWbVVNazVSNnNJUkdGbnVWYko1MDNSY0FJcEFYZm9BQlJvZXFCd2NLK09aeEdjM3luMkhhQldmU052clNhUWFFR2VGMWxZV0JpVWd4VGJlaEI4Y2Ztbld3QT09";
        $encrptopenssl = new Opensslencryptdecrypt();
        $json          = $encrptopenssl->decrypt($cadena, true);
        echo $json;
    }

    private function setConf()
    {
        $conf = @file_get_contents("system/oficina.json");

        $this->session->set_userdata('salaEspera2', '0');
        $this->session->set_userdata('ipCAR', '');
        $this->session->set_userdata('informeWebCornare', $this->informeWebCornare);
        $this->session->set_userdata('sicov', "");
        $this->session->set_userdata('firmaDigital', "");
        $this->session->set_userdata('grant_type', '0');
        $this->session->set_userdata('client_id', '0');
        $this->session->set_userdata('client_secret', '0');
        $this->session->set_userdata('informeWebBogota', '0');
        $this->session->set_userdata('huellaDigital', '0');
        $this->session->set_userdata('cargaCertificado', '0');
        $this->session->set_userdata('ipServidor', '127.0.0.1');
        if (isset($conf)) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json          = $encrptopenssl->decrypt($conf, true);
            $dat           = json_decode($json, true);
            foreach ($dat as $d) {
                //                echo $conf;
                if ($d['nombre'] == "salaEspera2") {
                    $this->session->set_userdata('salaEspera2', $d['valor']);
                }
                if ($d['nombre'] == "ipCAR") {
                    $this->session->set_userdata('ipCAR', $d['valor']);
                }
                if ($d['nombre'] == "informeWebCornare") {
                    $this->session->set_userdata('informeWebCornare', $d['valor']);
                }
                if ($d['nombre'] == "sicov") {
                    $this->session->set_userdata('sicov', $d['valor']);
                }
                if ($d['nombre'] == "firmaDigital") {
                    $this->session->set_userdata('firmaDigital', $d['valor']);
                }
                if ($d['nombre'] == 'grant_type') {
                    $this->session->set_userdata('grant_type', $d['valor']);
                }
                if ($d['nombre'] == 'client_id') {
                    $this->session->set_userdata('client_id', $d['valor']);
                }
                if ($d['nombre'] == 'client_secret') {
                    $this->session->set_userdata('client_secret', $d['valor']);
                }
                if ($d['nombre'] == 'informeWebBogota') {
                    $this->session->set_userdata('informeWebBogota', $d['valor']);
                }
                if ($d['nombre'] == "huellaDigital") {
                    $this->session->set_userdata('huellaDigital', $d['valor']);
                }
                if ($d['nombre'] == "cargaCertificado") {
                    $this->session->set_userdata('cargaCertificado', $d['valor']);
                }
                if ($d['nombre'] == "ipServidor") {
                    $this->session->set_userdata('ipServidor', $d['valor']);
                }
            }
        }
    }

    public function CGVenPista()
    {
        $datos = explode('-', $this->input->post('dato'));
        if ($datos[1] == '0' || $datos[1] == '4444' || $datos[1] == '8888') {
            $ocacion = 'PRIMERA VEZ';
        } else {
            $ocacion = 'SEGUNDA VEZ';
        }
        if ($datos[1] == '0' || $datos[1] == '1') {
            $ti = "1";
            if ($datos[1] == '0') {
                $reinspeccion = 0;
            } else {
                $reinspeccion = 1;
            }
        } elseif ($datos[1] == '4444' || $datos[1] == '44441') {
            $ti = "2";
            if ($datos[1] == '4444') {
                $reinspeccion = 0;
            } else {
                $reinspeccion = 1;
            }
        } else {
            $ti           = "3";
            $reinspeccion = 0;
        }
        $data['dato']   = $this->input->post('dato') . "-1";
        $rta            = $this->MGPrueba->getPlaca($datos[0]);
        $data['placaR'] = $rta->result();
        //        $data['vehiculo'] = $this->MGPrueba->getVehiculoEnPista($datos[0]);
        $data['ocacion']       = $ocacion;
        $data['idhojapruebas'] = $datos[0];
        $data['pendientes']    = $this->MGPrueba->pruebasPendientes($datos[0]);
        $data['presion']       = $this->getPresiones($data['placaR'][0]->placa, $reinspeccion, $this->Mutilitarios->getNow(), $ti);
        //        $encrptopenssl = new Opensslencryptdecrypt();
        //        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        //        $ofc = json_decode($json, true);
        //        foreach ($ofc as $d) {
        //            $data[$d['nombre']] = $d['valor'];
        //        }

        $this->load->view('oficina/gestion/VGVenPista', $data);
    }

    public function CGVfinalizado()
    {
        $datos = explode('-', $this->input->post('dato'));
        if ($datos[1] == '0' || $datos[1] == '4444' || $datos[1] == '8888') {
            $ocacion = 'PRIMERA VEZ';
        } else {
            $ocacion = 'SEGUNDA VEZ';
        }
        $data['dato']          = $this->input->post('dato');
        $data['vehiculo']      = $this->MGPrueba->getVehiculoEnPista($datos[0]);
        $data['ocacion']       = $ocacion;
        $data['idhojapruebas'] = $datos[0];
        if (isset($datos[2])) {
            $data['res'] = $datos[2];
        }
        $data['reinspeccion'] = $datos[1];
        $this->setConf();
        $this->load->view('oficina/gestion/VGVfinalizado', $data);
    }

    public function CGVrechaSinFirmar()
    {
        $data                   = $this->cargar($this->input->post('dato'));
        $datos                  = explode("-", $this->input->post('dato'));
        $datHT['jefelinea']     = $data['jefePista']->valor;
        $datHT['idhojapruebas'] = $datos[0];
        if ($datos[1] !== '0' && $datos[1] !== '1') {
            $datHT['estadototal'] = '3';
        } else {
            $datHT['estadototal'] = '1';
        }
        $this->setConf();
        $rta            = $this->MGPrueba->getPlaca($datos[0]);
        $data['placaR'] = $rta->result();
        $this->Mhojatrabajo->update($datHT);
        $this->load->view('oficina/gestion/VGVrechaSinFirmar', $data);
    }

    //     public function guardarJefeLinea($placa,$id) {
    //        $id = $this->input->post('id');
    //        $numero_placa_ref = $this->input->post('numero_placa_ref');
    //        $reinspeccion = $this->input->post('reinspeccion');
    //        $tipo_inspeccion = $this->input->post('tipo_inspeccion');
    //        $valor = $this->input->post('valor');
    //        $pre_prerevision['numero_placa_ref'] = $numero_placa_ref;
    //        $pre_prerevision['reinspeccion'] = $reinspeccion;
    //        $pre_prerevision['tipo_inspeccion'] = $tipo_inspeccion;
    //        $idpre_prerevision = $this->Mpre_prerevision->getXidPre($pre_prerevision);
    //        $pre_atributo['id'] = $id;
    //        $idpre_atributo = $this->Mpre_atributo->getXid($pre_atributo);
    //        $rta_pre = $idpre_atributo->result();
    //        $pre_dato['idpre_atributo'] = $rta_pre[0]->idpre_atributo;
    //        $pre_dato['idpre_zona'] = '0';
    //        $pre_dato['idpre_prerevision'] = $idpre_prerevision;
    //        $pre_dato['valor'] = $valor;
    //        $this->Mpre_dato->guardar($pre_dato);
    //    }

    public function CGVrechaEnvioFirmar()
    {
        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $datHT['estadototal']   = '3';
        $datHT['sicov']         = '1';
        $datHT['reinspeccion']  = $this->input->post('reinspeccion');
        $this->Mhojatrabajo->update_x($datHT);
        $this->insertarEvento($this->input->post('placa'), "idUsuario: " . $this->session->userdata('IdUsuario'), "f", "1", "Acción de usuario: Transacción exitosa|X|" . $this->input->post('ocasion') . "|1|Estado cambiado por el usuario de RECHAZADO SIN FIRMAR a RECHAZADO SIN CONSECUTIVO");
    }

    public function CGVaproSinFirmar()
    {
        $data                   = $this->cargar($this->input->post('dato'));
        $datos                  = explode("-", $this->input->post('dato'));
        $datHT['jefelinea']     = $data['jefePista']->valor;
        $datHT['idhojapruebas'] = $datos[0];
        if ($datos[1] !== '0' && $datos[1] !== '1') {
            $datHT['estadototal'] = '2';
        } else {
            $datHT['estadototal'] = '1';
        }
        $this->setConf();
        $rta            = $this->MGPrueba->getPlaca($datos[0]);
        $data['placaR'] = $rta->result();
        $this->Mhojatrabajo->update($datHT);
        $this->load->view('oficina/gestion/VGVaproSinFirmar', $data);
    }

    public function validEventosFinalizados()
    {
        echo json_encode($this->MGPrueba->validEventosFinalizados($this->input->post("placa")));
    }

    public function CGVaproEnvioFirmar()
    {
        //        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $idhojapruebas          = str_replace("-,0,1", "", $this->input->post('idhojapruebas'));
        $datHT['idhojapruebas'] = $idhojapruebas;
        $datHT['estadototal']   = '2';
        $datHT['sicov']         = '1';
        $datHT['reinspeccion']  = $this->input->post('reinspeccion');
        $this->Mhojatrabajo->update_x($datHT);
        $this->insertarEvento($this->input->post('placa'), "idUsuario: " . $this->session->userdata('IdUsuario'), "f", "1", "Acción de usuario: Transacción exitosa|X|" . $this->input->post('ocasion') . "|1|Estado cambiado por el usuario de APROBADO SIN FIRMAR a APROBADO SIN CONSECUTIVO");
    }

    public function CGVrechaSinConsecutivo()
    {
        $this->setConf();
        $data                      = $this->cargar2($this->input->post('dato'));
        $data['ipCAR']             = $this->session->userdata('ipCAR');
        $data['informeWebCornare'] = $this->session->userdata('informeWebCornare');
        $this->load->view('oficina/gestion/VGVrechaSinConsecutivo', $data);
    }

    public function CGVrechaEnvioAnulacion()
    {
        //        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $idhojapruebas          = str_replace("-,0,1", "", $this->input->post('idhojapruebas'));
        $datHT['idhojapruebas'] = $idhojapruebas;
        $datHT['estadototal']   = '1';
        $datHT['sicov']         = '0';
        $datHT['reinspeccion']  = $this->input->post('reinspeccion');
        $this->Mhojatrabajo->update_x($datHT);
        $this->insertarEvento($this->input->post('placa'), "idUsuario: " . $this->session->userdata('IdUsuario'), "r", "1", "Acción de usuario: Transacción exitosa|X|" . $this->input->post('ocasion') . "|1|Estado cambiado por el usuario de RECHAZADO SIN CONSECUTIVO a RECHAZADO SIN FIRMAR");
    }

    public function CGVaproSinConsecutivo()
    {
        $this->setConf();
        $data                      = $this->cargar2($this->input->post('dato'));
        $data['ipCAR']             = $this->session->userdata('ipCAR');
        $data['cargaCertificado']  = $this->session->userdata('cargaCertificado') == '1' ? true : false;
        $data['informeWebCornare'] = $this->session->userdata('informeWebCornare');

        // $dato  = "654324658-0";
        // $datos = explode('-', $dato);
        // if ($datos[1] == '0' || $datos[1] == '4444' || $datos[1] == '8888') {
        //     $ocacion = 'PRIMERA VEZ';
        // } else {
        //     $ocacion = 'SEGUNDA VEZ';
        // }
        // $data['dato']                   = $dato;
        // $data['vehiculo']               = new stdClass();
        // $data['vehiculo']->numero_placa = "CFO609";
        // $data['ocacion']                = $ocacion;
        // $data['idhojapruebas']          = $datos[0];
        // $data['reinspeccion']           = $datos[1];
        // $data['vehiculo']->placa        = "CFO609";
        // $data['placa']                  = "CFO609";
        // $data['ipCAR']                  = "192.168.1.22";
        // $data['informeWebCornare']      = "0";
        // $data['cargaCertificado']       =  $this->session->userdata('cargaCertificado') == '1' ? true : false;
        // $data['tipo_combustible'] = $data['vehiculo']->numero_placa;

        $this->load->view('oficina/gestion/VGVaproSinConsecutivo', $data);
    }

    public function subirCertificado()
    {
        header('Content-Type: application/json');

        try {
            if (! isset($_FILES['certificado'])) {
                echo json_encode(['success' => false, 'message' => 'No se recibió ningún archivo']);
                return;
            }

            $archivo           = $_FILES['certificado'];
            $consecutivoRunt   = $this->input->post('consecutivoRunt');
            $placa             = $this->input->post('placa');
            $idhojapruebas     = $this->input->post('idhojapruebas');
            $rutaPersonalizada = $this->input->post('rutaDestino');

            // Validaciones básicas
            if ($archivo['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'message' => 'Error al subir el archivo']);
                return;
            }

            if ($archivo['type'] !== 'application/pdf') {
                echo json_encode(['success' => false, 'message' => 'Solo se permiten archivos PDF']);
                return;
            }

            if ($archivo['size'] > 5 * 1024 * 1024) {
                echo json_encode(['success' => false, 'message' => 'El archivo no debe superar los 5MB']);
                return;
            }

            // NUEVA VALIDACIÓN: Enviar archivo a Gemini para validación
            $validacionResult = $this->validarCertificadoConGemini($archivo['tmp_name'], $placa, $consecutivoRunt);

            if (! $validacionResult['valido']) {
                echo json_encode(['success' => false, 'message' => $validacionResult['mensaje']]);
                return;
            }

            // Si la validación es exitosa, proceder a guardar el archivo
            $uploadDir = $rutaPersonalizada ?: 'uploads/certificados/';

            if (substr($uploadDir, -1) !== '/') {
                $uploadDir .= '/';
            }

            if (! is_dir($uploadDir)) {
                if (! mkdir($uploadDir, 0777, true)) {
                    echo json_encode(['success' => false, 'message' => 'No se pudo crear el directorio especificado']);
                    return;
                }
            }

            $nombreArchivo = 'certificado_' . $placa . '_' . $consecutivoRunt . '_' . time() . '.pdf';
            $rutaDestino   = $uploadDir . $nombreArchivo;

            if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
                echo json_encode([
                    'success'    => true,
                    'message'    => "Certificado validado y guardado exitosamente en: $rutaDestino",
                    'archivo'    => $nombreArchivo,
                    'ruta'       => $rutaDestino,
                    'validacion' => $validacionResult['datos_extraidos'],
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar el archivo en la ubicación especificada']);
            }

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    private function validarCertificadoConGemini($rutaArchivo, $placaEsperada, $consecutivoEsperado)
    {
        try {
            // Leer el archivo PDF
            $archivoContenido = file_get_contents($rutaArchivo);
            if ($archivoContenido === false) {
                return [
                    'valido'  => false,
                    'mensaje' => 'No se pudo leer el archivo PDF',
                ];
            }

            // Preparar los datos para el formulario multipart
            $boundary = '----FormBoundary' . md5(time());
            $prompt   = 'Trae el numero de certificado y la placa que se encuentran el documento, ten encuenta que el numero del certificado se encuentra abajo del titulo "CERTIFICADO DE REVISIÓN TÉCNICO MECÁNICA Y DE EMISIONES CONTAMINANTES" junto a "No." traelo en este formato "certificado|placa", si dectectas que el documento no es un certificado de inspección dime "na".';

            // Construir el cuerpo del formulario multipart
            $postData = '';

            // Agregar el campo prompt
            $postData .= "--$boundary\r\n";
            $postData .= "Content-Disposition: form-data; name=\"prompt\"\r\n\r\n";
            $postData .= $prompt . "\r\n";

            // Agregar el archivo
            $postData .= "--$boundary\r\n";
            $postData .= "Content-Disposition: form-data; name=\"files\"; filename=\"certificado.pdf\"\r\n";
            $postData .= "Content-Type: application/pdf\r\n\r\n";
            $postData .= $archivoContenido . "\r\n";
            $postData .= "--$boundary--\r\n";

            // Configurar el contexto para file_get_contents
            $options = [
                'http' => [
                    'method'  => 'POST',
                    'header'  => "Content-Type: multipart/form-data; boundary=$boundary\r\n" .
                    "Content-Length: " . strlen($postData) . "\r\n",
                    'content' => $postData,
                    'timeout' => 30,
                ],
            ];

            $context = stream_context_create($options);

            // Realizar la petición
            $response = @file_get_contents('http://' . $this->session->userdata('ipServidor') . ':3900/api/gemini/certificado-prompt-stream', false, $context);

            if ($response === false) {
                return [
                    'valido'  => false,
                    'mensaje' => 'Error de conexión con el servicio de validación. Verifique que el servicio esté disponible.',
                ];
            }

            // Procesar respuesta
            $response = trim($response);

            if ($response === 'na') {
                return [
                    'valido'  => false,
                    'mensaje' => 'El documento no es un certificado de inspección válido',
                ];
            }

            // Extraer datos del certificado
            $partes = explode('|', $response);

            if (count($partes) !== 2) {
                return [
                    'valido'  => false,
                    'mensaje' => 'No se pudieron extraer los datos del certificado correctamente. Respuesta: ' . $response,
                ];
            }

            $certificadoExtraido = trim($partes[0]);
            $placaExtraida       = trim($partes[1]);

            // Validar coincidencias
            $errores = [];

            // Validar placa (sin importar mayúsculas/minúsculas)
            if (strtoupper($placaExtraida) !== strtoupper($placaEsperada)) {
                $errores[] = "La placa del certificado ($placaExtraida) no coincide con la placa registrada ($placaEsperada)";
            }

            // Validar consecutivo RUNT
            if ($certificadoExtraido !== $consecutivoEsperado) {
                $errores[] = "El número de certificado ($certificadoExtraido) no coincide con el consecutivo RUNT registrado ($consecutivoEsperado)";
            }

            if (! empty($errores)) {
                return [
                    'valido'          => false,
                    'mensaje'         => 'La información del certificado no coincide: ' . implode('. ', $errores),
                    'datos_extraidos' => [
                        'certificado' => $certificadoExtraido,
                        'placa'       => $placaExtraida,
                    ],
                ];
            }

            return [
                'valido'          => true,
                'mensaje'         => 'Certificado validado correctamente',
                'datos_extraidos' => [
                    'certificado' => $certificadoExtraido,
                    'placa'       => $placaExtraida,
                ],
            ];

        } catch (Exception $e) {
            return [
                'valido'  => false,
                'mensaje' => 'Error durante la validación: ' . $e->getMessage(),
            ];
        }
    }

    public function CGVaproEnvioAnulacion()
    {
        //        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $idhojapruebas          = str_replace("-,0,1", "", $this->input->post('idhojapruebas'));
        $datHT['idhojapruebas'] = $idhojapruebas;
        $datHT['estadototal']   = '1';
        $datHT['sicov']         = '0';
        if ($this->input->post('ocasion') == "PRIMERA VEZ") {
            $reinspeccion = 0;
        } else {
            $reinspeccion = 1;
        }
        $datHT['reinspeccion'] = $this->input->post('reinspeccion');
        $this->Mhojatrabajo->update_x($datHT);
        $this->insertarEvento($this->input->post('placa'), "idUsuario: " . $this->session->userdata('IdUsuario'), "r", "1", "Acción de usuario: Transacción exitosa|X|" . $this->input->post('ocasion') . "|1|Estado cambiado por el usuario de APROBADO SIN CONSECUTIVO a APROBADO SIN FIRMAR");
    }

    private function cargar($dato)
    {
        $datos = explode('-', $dato);
        if ($datos[1] == '0' || $datos[1] == '4444' || $datos[1] == '8888') {
            $ocacion = 'PRIMERA VEZ';
        } else {
            $ocacion = 'SEGUNDA VEZ';
        }
        $data['dato']          = $dato;
        $data['vehiculo']      = $this->MGPrueba->getVehiculoEnPista($datos[0]);
        $data['rechazadas']    = $this->MGPrueba->pruebasRechazadas($data['vehiculo']->numero_placa);
        $data['ocacion']       = $ocacion;
        $data['idhojapruebas'] = $datos[0];
        $data['reinspeccion']  = $datos[1];
        $data['placa']         = $data['vehiculo']->numero_placa;
        $data['mensajeExito']  = "";
        $data['jefePista']     = $this->getJefePista('182');
        $data['jefesPista']    = $this->getJefesdePista();
        return $data;
    }

    private function cargar2($dato)
    {
        $datos = explode('-', $dato);
        if ($datos[1] == '0' || $datos[1] == '4444' || $datos[1] == '8888') {
            $ocacion = 'PRIMERA VEZ';
        } else {
            $ocacion = 'SEGUNDA VEZ';
        }
        $data['dato']             = $dato;
        $data['vehiculo']         = $this->MGPrueba->getVehiculoEnPista($datos[0]);
        $data['ocacion']          = $ocacion;
        $data['idhojapruebas']    = $datos[0];
        $data['reinspeccion']     = $datos[1];
        $data['placa']            = $data['vehiculo']->numero_placa;
        $data['tipo_combustible'] = $data['vehiculo']->numero_placa;
        return $data;
    }

    private function insertarEvento($idelemento, $cadena, $tipo, $enviado, $respuesta)
    {
        $data['idelemento'] = $idelemento;
        $data['cadena']     = $cadena;
        $data['tipo']       = $tipo;
        $data['enviado']    = $enviado;
        $data['respuesta']  = $respuesta;
        $this->MEventosindra->insert($data);
    }

    private function getJefePista($idCP)
    {
        $data['idconfig_prueba'] = $idCP;
        $result                  = $this->Mconfig_prueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return '';
        }
    }

    private function getJefesdePista()
    {
        $result = $this->Musuarios->getXperfil('3');
        if ($result->num_rows() > 0) {
            return $result;
        } else {
            return '';
        }
    }

    public function setJefePista()
    {
        $jefe                   = $this->input->post('jefepista');
        $datHT['jefelinea']     = $jefe;
        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $this->Mhojatrabajo->update_JefePista($datHT);
        $datCP['valor']           = $jefe;
        $datCP['idconfig_prueba'] = '182';
        $this->Mconfig_prueba->update($datCP);
    }

    public function actualizarEnvioSicov()
    {
        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $datHT['sicov']         = '1';
        $this->Mhojatrabajo->update_($datHT);
    }

    public function Cllamar()
    {
        $dato                   = explode('-', $this->input->post('dato'));
        $llamar                 = $this->input->post('llamar');
        $datHT['llamar']        = $llamar;
        $datHT['idhojapruebas'] = $dato[0];
        $this->Mhojatrabajo->update_llamar($datHT);
        //        echo $this->salaEspera2;
        if ($this->session->userdata('salaEspera2') == "1") {
            $sala['idhojaprueba']  = $dato[0];
            $sala['idtipo_prueba'] = "21";
            $sala['estado']        = "1";
            $sala['actualizado']   = "0";
            echo $this->Mcontrol_salae->insertar($sala);
        }
        redirect('/oficina/Cgestion');
    }

    public function guardarConsecutivoAprobado()
    {
        $data['idhojapruebas']              = $this->input->post('idhojapruebas');
        $data['numero_certificado']         = $this->input->post('consecutivorunt');
        $data['fechaimpresion']             = $this->Mutilitarios->getNow();
        $data['fecha_vigencia']             = $this->Mutilitarios->getFechaSumY(1);
        $data['usuario']                    = $this->session->userdata('IdUsuario');
        $data['estado']                     = '1';
        $data['consecutivo_runt']           = $this->input->post('consecutivorunt');
        $data['consecutivo_runt_rechazado'] = '';
        $this->Mcertificados->insert($data);
    }

    public function guardarConsecutivoRechazado()
    {
        $data['idhojapruebas']              = $this->input->post('idhojapruebas');
        $data['numero_certificado']         = '';
        $data['fechaimpresion']             = $this->Mutilitarios->getNow();
        $data['fecha_vigencia']             = '0000-00-00';
        $data['usuario']                    = $this->session->userdata('IdUsuario');
        $data['estado']                     = '2';
        $data['consecutivo_runt']           = '';
        $data['consecutivo_runt_rechazado'] = $this->input->post('consecutivorunt');
        $this->Mcertificados->insert($data);
    }

    public function guardarPresion()
    {
        $id                                  = $this->input->post('id');
        $numero_placa_ref                    = $this->input->post('numero_placa_ref');
        $reinspeccion                        = $this->input->post('reinspeccion');
        $tipo_inspeccion                     = $this->input->post('tipo_inspeccion');
        $valor                               = $this->input->post('valor');
        $pre_prerevision['numero_placa_ref'] = $numero_placa_ref;
        $pre_prerevision['reinspeccion']     = $reinspeccion;
        $pre_prerevision['tipo_inspeccion']  = $tipo_inspeccion;
        $idpre_prerevision                   = $this->Mpre_prerevision->getXidPre($pre_prerevision);
        $pre_atributo['id']                  = $id;
        $idpre_atributo                      = $this->Mpre_atributo->getXid($pre_atributo);
        $rta_pre                             = $idpre_atributo->result();
        $pre_dato['idpre_atributo']          = $rta_pre[0]->idpre_atributo;
        $pre_dato['idpre_zona']              = '0';
        $pre_dato['idpre_prerevision']       = $idpre_prerevision;
        $pre_dato['valor']                   = $valor;
        $this->Mpre_dato->guardar($pre_dato);
    }

    private function getPresiones($placa, $reinspeccion, $fecha, $tipo)
    {
        $data['numero_placa_ref']  = $placa;
        $data['reinspeccion']      = $reinspeccion;
        $data['tipo_inspeccion']   = $tipo;
        $data['fecha_prerevision'] = $fecha;
        $dat_pre                   = $this->Mpre_prerevision->getDatos($data);
        if ($dat_pre) {
            foreach ($dat_pre->result() as $d) {
                switch ($d->id) {
                    case 'llanta-1-1-a':
                        $this->llanta_1_D = $d->valor;
                        break;
                    case 'llanta-2-1-a':
                        $this->llanta_2_DE = $d->valor;
                        break;
                    case 'llanta-1-D-a':
                        $this->llanta_1_D = $d->valor;
                        break;
                    case 'llanta-1-D-a':
                        $this->llanta_1_D = $d->valor;
                        break;
                    case 'llanta-1-I-a':
                        $this->llanta_1_I = $d->valor;
                        break;
                    case 'llanta-2-D-a':
                        $this->llanta_2_DE = $d->valor;
                        break;
                    case 'llanta-2-I-a':
                        $this->llanta_2_IE = $d->valor;
                        break;
                    case 'llanta-R-a':
                        $this->llanta_R = $d->valor;
                        break;
                    case 'llanta-2-DI-a':
                        $this->llanta_2_DI = $d->valor;
                        break;
                    case 'llanta-2-II-a':
                        $this->llanta_2_II = $d->valor;
                        break;
                    case 'llanta-2-DE-a':
                        $this->llanta_2_DE = $d->valor;
                        break;
                    case 'llanta-2-IE-a':
                        $this->llanta_2_IE = $d->valor;
                        break;
                    case 'llanta-3-DI-a':
                        $this->llanta_3_DI = $d->valor;
                        break;
                    case 'llanta-3-II-a':
                        $this->llanta_3_II = $d->valor;
                        break;
                    case 'llanta-3-DE-a':
                        $this->llanta_3_DE = $d->valor;
                        break;
                    case 'llanta-3-IE-a':
                        $this->llanta_3_IE = $d->valor;
                        break;
                    case 'llanta-4-DI-a':
                        $this->llanta_4_DI = $d->valor;
                        break;
                    case 'llanta-4-II-a':
                        $this->llanta_4_II = $d->valor;
                        break;
                    case 'llanta-4-DE-a':
                        $this->llanta_4_DE = $d->valor;
                        break;
                    case 'llanta-4-IE-a':
                        $this->llanta_4_IE = $d->valor;
                        break;
                    case 'llanta-5-DI-a':
                        $this->llanta_5_DI = $d->valor;
                        break;
                    case 'llanta-5-II-a':
                        $this->llanta_5_II = $d->valor;
                        break;
                    case 'llanta-5-DE-a':
                        $this->llanta_5_DE = $d->valor;
                        break;
                    case 'llanta-5-IE-a':
                        $this->llanta_5_IE = $d->valor;
                        break;
                    default:
                        break;
                }
            }
        }
        $presiones = (object)
            [
            'llanta_1_I'  => $this->llanta_1_I,
            'llanta_1_D'  => $this->llanta_1_D,
            'llanta_2_IE' => $this->llanta_2_IE,
            'llanta_2_DE' => $this->llanta_2_DE,
            'llanta_2_II' => $this->llanta_2_II,
            'llanta_2_DI' => $this->llanta_2_DI,
            'llanta_3_II' => $this->llanta_3_II,
            'llanta_3_IE' => $this->llanta_3_IE,
            'llanta_3_DI' => $this->llanta_3_DI,
            'llanta_3_DE' => $this->llanta_3_DE,
            'llanta_4_II' => $this->llanta_4_II,
            'llanta_4_IE' => $this->llanta_4_IE,
            'llanta_4_DI' => $this->llanta_4_DI,
            'llanta_4_DE' => $this->llanta_4_DE,
            'llanta_5_II' => $this->llanta_5_II,
            'llanta_5_IE' => $this->llanta_5_IE,
            'llanta_5_DI' => $this->llanta_5_DI,
            'llanta_5_DE' => $this->llanta_5_DE,
            'llanta_R'    => $this->llanta_R,
            'llanta_R2'   => $this->llanta_R2,
        ];
        return $presiones;
    }

    //---------------------------------------INTEGRACION 20210320 BRAYAN LEON
    public function getPruebas()
    {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $reinspeccion  = $this->input->post('reinspeccion');
        switch ($reinspeccion) {
            case 0:
            case 4444:
            case 8888:
                $rta = $this->MGPrueba->getPruebasprimera($idhojapruebas);
                echo json_encode($rta);
                break;
            case 1:
            case 44441:
                $rta = $this->MGPrueba->getPruebassegunda($idhojapruebas, $reinspeccion);
                echo json_encode($rta);
                break;
            default:
                break;
        }
    }

    public function getPruebasvisual()
    {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $reinspeccion  = $this->input->post('reinspeccion');
        switch ($reinspeccion) {
            case 0:
            case 4444:
            case 8888:
                $rta = $this->MGPrueba->getPruebasVisualprimera($idhojapruebas);
                echo json_encode($rta);
                break;
            case 1:
            case 44441:
                $rta = $this->MGPrueba->getPruebasVisualsegunda($idhojapruebas);
                echo json_encode($rta);
                break;
            default:
                break;
        }
    }

    public function getCreateCaptador()
    {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $fechainicial  = $this->input->post('fechainicial');
        $rta           = $this->MGPrueba->getCreateCaptador($idhojapruebas, $fechainicial);
        echo json_encode($rta);
    }

    public function updateVisual()
    {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $idvisual      = $this->input->post('idvisual');
        $rtah          = $this->MGPrueba->updateHojatrabajo($idhojapruebas);
        $rtav          = $this->MGPrueba->updateVisual($idhojapruebas, $idvisual);
        if ($rtah == 1 && $rtav == 1) {
            $rta = 1;
            echo json_encode($rta);
        }
    }

    public function updatePruebasVisual()
    {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $idtipoprueba  = $this->input->post('idtipoprueba');
        $idtipo_prueba = $this->input->post('idtipo_prueba');
        switch ($idtipo_prueba) {
            case 21:
            case 22:
                $rta = $this->MGPrueba->deletePerifericos($idhojapruebas, $idtipoprueba);
                echo json_encode($rta);
                break;
            default:
                $rta = $this->MGPrueba->updatePruebasVisual($idhojapruebas, $idtipoprueba);
                echo json_encode($rta);
                break;
        }
    }

    public function updatePruebas()
    {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $idtipoprueba  = $this->input->post('idprueba');
        $idtipo_prueba = $this->input->post('idtipo_prueba');
        $prueba        = $this->input->post('prueba');
        $rtah          = $this->MGPrueba->updateHojatrabajo($idhojapruebas);
        $rtapru        = $this->MGPrueba->updatePruebas($idhojapruebas, $idtipoprueba, $idtipo_prueba, $prueba);
        if ($rtah == 1 && $rtapru == 1) {
            $rta = 1;
            echo json_encode($rta);
        }
    }

    //-------------------------------------------------------- fin de reasignacion individual------------------------------------------//
    public function Vpin_estado()
    {
        //        $placa = 'CQZ501';
        // $data = $this->MGPrueba->getPlaca($placa);
        // $rta['placa'] = $data->result();
        $this->load->view('oficina/configprueba/Vcambiarpinyestado');
    }

    public function updateEstadoPin()
    {
        $estado        = $this->input->post('estado');
        $pin           = $this->input->post('pin');
        $idhojapruebas = $this->input->post('idhojapruebas');
        if ($estado != 0) {
            $rta = $this->MGPrueba->getHojatrabajoPin($estado, $pin, $idhojapruebas);
            echo json_encode('El estado y pin fueron actualizados.');
        } else {
            $rta = $this->MGPrueba->getHojatrabajoPinEstado($pin, $idhojapruebas);
            echo json_encode('El pin fue actualizado.');
        }
    }

    //-------------------------------------------------------- fin de actualizacion estado y pin ------------------------------------------//
    public function reConfvehiculosPruebas()
    {
        $selectrecofprueba = $this->input->post('selectrecofprueba');
        $idhojapruebas     = $this->input->post('idhojapruebas');
        $pfechainicial     = $this->input->post('pfechainicial');
        $servicio          = $this->input->post('servicio');
        $combustible       = $this->input->post('combustible');
        $tipovehiculo      = $this->input->post('tipovehiculo');
        $placa             = $this->input->post('placa');
        switch ($selectrecofprueba) {
            case 1:
                $servicio = 2;
                $rtah     = $this->MGPrueba->Createtaximetro($idhojapruebas, $pfechainicial);
                $rtav     = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se asigno la prueba taxímetro y se modifico el servicio a público.');
                }
                break;
            case 2:
                $servicio = 3;
                $rtah     = $this->MGPrueba->deleteTaximetro($idhojapruebas);
                $rtav     = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se elimino la prueba taxímetro y se modifico el servicio a particular.');
                }
                break;
            case 3:
                $rtah         = $this->MGPrueba->livianoapesado($idhojapruebas, $pfechainicial);
                $combustible  = 1;
                $tipovehiculo = 2;
                $rtav         = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de liviano a pesado.');
                }
                break;
            case 4:
                $rtah         = $this->MGPrueba->pesadoliviano($idhojapruebas, $pfechainicial);
                $combustible  = 2;
                $tipovehiculo = 1;
                $rtav         = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de pesado a liviano.');
                }
                break;
            case 5:
                $rtah         = $this->MGPrueba->motoLiviano($idhojapruebas, $pfechainicial);
                $tipovehiculo = 1;
                $rtav         = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de moto a liviano.');
                }
                break;
            case 6:
                $rtah         = $this->MGPrueba->livianoMoto($idhojapruebas, $pfechainicial);
                $tipovehiculo = 3;
                $rtav         = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de liviano a moto.');
                }
                break;
            case 7:
                $rtah         = $this->MGPrueba->pesadoMoto($idhojapruebas, $pfechainicial);
                $combustible  = 2;
                $tipovehiculo = 3;
                $rtav         = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de pesado a moto.');
                }
                break;
            case 8:
                $rtah         = $this->MGPrueba->motoPesado($idhojapruebas, $pfechainicial);
                $combustible  = 1;
                $tipovehiculo = 2;
                $rtav         = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de moto a pesado.');
                }
                break;
            case 9:
                //Particular a pÃºblico
                $servicio = 2;
                $rtav     = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de particular a público.');
                }
                break;
            case 10:
                //PÃºblico a prarticula
                $servicio = 3;
                $rtav     = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de público a particular.');
                }
                break;
            case 11:
                //gasolina a disel
                $combustible = 1;
                $rtav        = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                $this->MGPrueba->AsignarDisel($idhojapruebas);
                if ($rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de gasolina a disel.');
                }
                break;
            case 12:
                //disel a gasolina
                $combustible = 2;
                $rtav        = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                $this->MGPrueba->AsignarGasolina($idhojapruebas);
                if ($rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de disel a gasolina.');
                }
                break;
            default:
                //asignar sonometro
                $rtah = $this->MGPrueba->asignarSonometro($idhojapruebas, $pfechainicial);
                if ($rtah == 1) {
                    echo json_encode('Se asigno la prueba de sonometria.');
                }
                break;
        }
    }

    //-------------------------------------------------------- fin de reconfiguracion de pruebas ------------------------------------------//
    public function cancelarPruebas()
    {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $reinspeccion  = $this->input->post('reinspeccion');
        $rta           = $this->MGPrueba->cancelarPruebas($idhojapruebas, $reinspeccion);
        if ($rta == 1) {
            echo json_encode('La prueba se cancelo.');
        }
    }

    //-------------------------------------------------------- fin cancelacion de pruebas ------------------------------------------//
    public function registroentrada()
    {
        $this->load->view('oficina/gestion/Vregistroentrada');
    }

    public function registroentradaselect()
    {
        $fechainicial = $this->input->post('fechainicial');
        $fechafinal   = $this->input->post('fechafinal');
        $idseleccion  = $this->input->post('idseleccion');
        $tip          = '';
        $where        = '';
        if (strval($idseleccion) !== "" || $idseleccion !== null) {
            $tip = "pp.tipo_inspeccion = " . $idseleccion . " AND ";
        }
        if ($fechainicial !== "" && $fechafinal !== "") {
            $where = "DATE_FORMAT(pp.fecha_prerevision,'%Y-%m-%d') BETWEEN '$fechainicial' AND '$fechafinal'";
        } else {
            $where = "DATE_FORMAT(pp.fecha_prerevision,'%Y-%m-%d')=DATE_FORMAT(NOW(),'%Y-%m-%d')";
        }
        $w   = $tip . $where;
        $rta = $this->MGPrueba->registroentrada($w);
        echo json_encode($rta);
    }

    public function download()
    {
        $query     = $this->MGPrueba->registroentrada();
        $filename  = 'Informe registro entrada.csv';
        $delimiter = ";";
        $newline   = "\r\n";
        $data      = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download($filename, $data);
    }

    private function error($mensaje)
    {
        $this->session->set_flashdata('error', $mensaje);
    }

    public function consultarConsecutivo()
    {
        echo json_encode($this->MGPrueba->consultarConsecutivo($this->input->post("idhojapruebas")));
    }

    public function guardarFirmaDigital()
    {

        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {

            if (! is_dir("tcm/firmafur/" . $this->input->post("idhojapruebas"))) {
                mkdir('tcm/firmafur/' . $this->input->post("idhojapruebas"), 0777, true);
            }
            $fopen         = fopen('tcm/firmafur/' . $this->input->post("idhojapruebas") . '/firma.dat', 'w+b');
            $encrptopenssl = new Opensslencryptdecrypt();
            $firma         = $encrptopenssl->encrypt($this->input->post('firma'));
            fwrite($fopen, $firma);
            fclose($fopen);
        } else {
            if (! is_dir('c:/tcm/firmafur/' . $this->input->post("idhojapruebas"))) {
                mkdir('c:/tcm/firmafur/' . $this->input->post("idhojapruebas"), 0777, true);
            }
            $fopen         = fopen('c:/tcm/firmafur/' . $this->input->post("idhojapruebas") . '/firma.dat', 'w+b');
            $encrptopenssl = new Opensslencryptdecrypt();
            $firma         = $encrptopenssl->encrypt($this->input->post('firma'));
            fwrite($fopen, $firma);
            fclose($fopen);
        }
    }

    public function getFirmaFur()
    {
        $encrptopenssl          = new Opensslencryptdecrypt();
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $file = "tcm/firmafur/" . $this->input->post('idhojapruebas') . "/firma.dat";
        } else {
            $file = "c:/tcm/firmafur/" . $this->input->post('idhojapruebas') . "/firma.dat";
        }

        if (file_exists($file)) {
            $firma = file_get_contents($file, true);
            echo $encrptopenssl->decrypt($firma);
        } else {
            echo "NA";
        }
    }

    public function getDilucion()
    {
        echo json_encode($this->MGPrueba->getDilucion($this->input->post('idhojapruebas'), $this->input->post('reinspeccion')));
    }
}
