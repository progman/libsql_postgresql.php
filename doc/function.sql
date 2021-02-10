-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS NOW_UTC();

CREATE OR REPLACE FUNCTION NOW_UTC()
RETURNS timestamp without time zone
LANGUAGE sql
AS $$SELECT timezone('UTC', timeofday()::timestamptz);$$;
-- AS $$SELECT NOW() at time zone 'UTC';$$;

ALTER function NOW_UTC() owner to postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS UTC_TO_UNIXMICROTIME(timestamp without time zone);

CREATE OR REPLACE FUNCTION UTC_TO_UNIXMICROTIME(timestamp without time zone)
RETURNS bigint
LANGUAGE sql IMMUTABLE STRICT
AS $_$SELECT (EXTRACT(EPOCH FROM $1) * 1000000)::bigint;$_$;

ALTER FUNCTION public.UTC_TO_UNIXMICROTIME(timestamp without time zone) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS UNIXMICROTIME_TO_UTC(bigint);

CREATE OR REPLACE FUNCTION UNIXMICROTIME_TO_UTC(bigint)
RETURNS timestamp without time zone
LANGUAGE sql IMMUTABLE STRICT
AS $_$SELECT (timestamp 'epoch' + (interval '1 s' * ($1/1000000)) + (interval '1 microseconds' * ($1 - (($1/1000000)*1000000))))::TIMESTAMP AS result$_$;

ALTER FUNCTION public.UNIXMICROTIME_TO_UTC(bigint) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS TIMESTAMP_TO_UNIXTIME(TIMESTAMP);

CREATE OR REPLACE FUNCTION TIMESTAMP_TO_UNIXTIME(TIMESTAMP)
RETURNS BIGINT
LANGUAGE SQL
IMMUTABLE STRICT
AS 'SELECT EXTRACT(EPOCH FROM $1)::bigint;';

ALTER FUNCTION public.TIMESTAMP_TO_UNIXTIME(TIMESTAMP) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS TIMESTAMPTZ_TO_UNIXTIME(TIMESTAMPTZ);

CREATE OR REPLACE FUNCTION TIMESTAMPTZ_TO_UNIXTIME(TIMESTAMPTZ)
RETURNS BIGINT
LANGUAGE SQL
IMMUTABLE STRICT
AS 'SELECT EXTRACT(EPOCH FROM $1)::bigint;';

ALTER FUNCTION public.TIMESTAMPTZ_TO_UNIXTIME(TIMESTAMPTZ) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS TIMESTAMPTZ_TO_UNIXTIME(TIMESTAMP);

CREATE OR REPLACE FUNCTION TIMESTAMPTZ_TO_UNIXTIME(TIMESTAMP)
RETURNS BIGINT
LANGUAGE SQL
IMMUTABLE STRICT
AS 'SELECT EXTRACT(EPOCH FROM $1::timestamptz)::bigint;';

ALTER FUNCTION public.TIMESTAMPTZ_TO_UNIXTIME(TIMESTAMP) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS INTERVAL_TO_UNIXTIME(INTERVAL);

CREATE OR REPLACE FUNCTION INTERVAL_TO_UNIXTIME(INTERVAL)
RETURNS BIGINT
LANGUAGE SQL
IMMUTABLE STRICT
AS 'SELECT EXTRACT(EPOCH FROM $1)::bigint;';

ALTER FUNCTION public.INTERVAL_TO_UNIXTIME(INTERVAL) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS UNIXTIME_TO_TIMESTAMP(INTEGER);

CREATE OR REPLACE FUNCTION UNIXTIME_TO_TIMESTAMP(INTEGER)
RETURNS TIMESTAMP
LANGUAGE SQL
IMMUTABLE STRICT
AS 'SELECT $1::abstime::timestamp AS result';

ALTER FUNCTION public.UNIXTIME_TO_TIMESTAMP(INTEGER) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS UNIXTIME_TO_TIMESTAMPTZ(INTEGER);

CREATE OR REPLACE FUNCTION UNIXTIME_TO_TIMESTAMPTZ(INTEGER)
RETURNS TIMESTAMPTZ
LANGUAGE SQL
IMMUTABLE STRICT
AS 'SELECT $1::abstime::timestamptz AS result';

ALTER FUNCTION public.UNIXTIME_TO_TIMESTAMPTZ(INTEGER) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS bytea_list2json(bytea_list bytea[]);

CREATE OR REPLACE FUNCTION bytea_list2json(bytea_list bytea[])
RETURNS text
LANGUAGE plpgsql AS $$
DECLARE
    item bytea;
    i bigint;
    size bigint;
    tmp text[];
BEGIN
    i := 1;
    size := array_length(bytea_list, 1) + 1;

    WHILE i < size
    LOOP
        item = bytea_list[i];
        tmp = array_append(tmp, encode(item, 'hex'));
        i = i + 1;
    END LOOP;

    RETURN to_json(tmp);
END
$$;

ALTER FUNCTION public.bytea_list2json(INTEGER) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS uuid_list2json(uuid_list uuid[]);

CREATE OR REPLACE FUNCTION uuid_list2json(uuid_list uuid[])
RETURNS json
LANGUAGE plpgsql AS $$
DECLARE
    item uuid;
    i bigint;
    size bigint;
    tmp text[];
BEGIN
    i := 1;
    size := array_length(uuid_list, 1) + 1;

    WHILE i < size
    LOOP
        item = uuid_list[i];
        tmp = array_append(tmp, replace(item::text, '-', ''));
        i = i + 1;
    END LOOP;

    RETURN to_json(tmp);
END
$$;

ALTER FUNCTION public.uuid_list2json(INTEGER) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS timestamp_list2json(timestamp_list timestamp[]);

CREATE OR REPLACE FUNCTION timestamp_list2json(timestamp_list timestamp[])
RETURNS json
LANGUAGE plpgsql AS $$
DECLARE
    item timestamp;
    i bigint;
    size bigint;
    tmp bigint[];
BEGIN
    i := 1;
    size := array_length(timestamp_list, 1) + 1;

    WHILE i < size
    LOOP
        item = timestamp_list[i];
        tmp = array_append(tmp, UTC_TO_UNIXMICROTIME(item)::bigint);
        i = i + 1;
    END LOOP;

    RETURN to_json(tmp);
END
$$;

ALTER FUNCTION public.timestamp_list2json(INTEGER) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS flag_list2json(flag_list boolean[]);

CREATE OR REPLACE FUNCTION flag_list2json(flag_list boolean[])
RETURNS json
LANGUAGE plpgsql AS $$
DECLARE
    item boolean;
    i bigint;
    size bigint;
    tmp int[];
BEGIN
    i := 1;
    size := array_length(flag_list, 1) + 1;

    WHILE i < size
    LOOP
        item = flag_list[i];
        tmp = array_append(tmp, item::int);
        i = i + 1;
    END LOOP;

    RETURN to_json(tmp);
END
$$;

ALTER FUNCTION public.flag_list2json(INTEGER) OWNER TO postgres;
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
